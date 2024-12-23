<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Point;
use App\Models\CardCode;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{

    public function merchantIndex(Request $request)
    {

        $user = request()->user();
        $searchFields = [
            'points.card_number',
            'customers.fname',
            'customers.mname',
            'customers.lname',
            'points.points',
        ];
        $tripidkards = Point::query()
        ->select('points.id AS point_id', 'points.*', 'customers.*')
            ->leftJoin('customers', 'points.card_number', '=', 'customers.customer_card_num')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('points.user_id', '=', $user->id)
            ->get();
        return response()->json($tripidkards);
    }

    public function store(Request $request)
{
    $user = request()->user();
    $merchant = User::with('merchant')->find($user->id);
    $totalStars = $merchant->merchant->stars_points;

    // Validate the request data
    $validated = $request->validate([
        'card_number' => 'required',
        'price' => 'required|numeric',
        'points' => 'nullable|numeric|min:1',  // Ensure loyalty points are at least 1
        'type' => 'required|in:discount,points', // Either Discount or Points
    ]);

    // Deduct points for loyalty stars (if points are being used)
    if ($validated['type'] === 'points') {
        if ($totalStars === 0) {
            return response()->json(['message' => 'You cannot add Loyalty Stars because you have 0 stars'], 422);
        }

        if ($validated['points'] > $totalStars) {
            return response()->json(['message' => 'You have exceeded your available loyalty stars.'], 422);
        }

        // Calculate remaining points after deduction
        $points = $totalStars - $validated['points'];
    }

    // Ensure the card number exists in the database and is active
    $cardCode = CardCode::where('card_number', $validated['card_number'])
        ->where('status', 1)
        ->first();

    if (!$cardCode) {
        return response()->json(['message' => 'Card number is not registered or is inactive.'], 422);
    }

    // Insert data for Discount type
    if ($validated['type'] === 'discount') {
        Discount::create([
            'user_id' => $user->id,
            'card_number' => $validated['card_number'],
            'product_price' => $validated['price'],
            'product_code' => $validated['product_code'] ?? null,
            'or_photo' => $validated['or_photo'] ?? null,
        ]);

        // Activity Log for Discount
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties(['role' => $user->role, 'status' => $user->status])
            ->log("{$user->fname} {$user->lname} applied a discount on card {$cardCode->card_number} with price {$validated['price']}");
    }

    // Insert data for Points type
    if ($validated['type'] === 'points') {
        // Only insert points if points > 0 and type is points
        if ($validated['points'] > 0) {
            Point::create([
                'user_id' => $user->id,
                'card_number' => $validated['card_number'],
                'product_code' => $validated['product_code'] ?? null,
                'points' => $validated['points'],
            ]);
        } else {
            return response()->json(['message' => 'Points must be greater than zero.'], 422);
        }

        // Activity Log for Points
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties(['role' => $user->role, 'status' => $user->status])
            ->log("{$user->fname} {$user->lname} added {$validated['points']} loyalty points to card {$cardCode->card_number}");
    }

    // If points were deducted, update merchant stars
    if (isset($points)) {
        $merchant->merchant->update(['stars_points' => $points]);
    }

    // Return success response
    return response()->json(['message' => 'Action performed successfully!']);
}


    public function edit(Point $point) {
        return $point;

    }

    public function update(Request $request, Point $point) {

        $validated = $request->validate([
            'points' => 'required',
        ]);

        $point->update($validated);

        $user = Auth::user();
        activity()
            ->performedOn($user)
            ->causedBy($user)
        ->withProperties(['role' => $user->role, 'status' => $user->status])
            ->log("$user->fname $user->lname updated $point->points points to $point->card_number");
        return response()->json(['success' => 'Points updated successfully']);

    }
}
