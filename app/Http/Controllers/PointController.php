<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Point;
use App\Models\CardCode;
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

        $validated = $request->validate([
            'card_number' => 'required',
            'price' => 'required|numeric',
            'points' => 'required|numeric',
        ]);

        $points = $totalStars - $validated['points'];

        if($totalStars === 0) {
            return response()->json(['message' => 'You Cant add Loyalty Stars you have 0 Stars'], 422); // Ayusin ang maximum limit at HTTP status code

        }
        else if( $validated['points'] > $totalStars ){
            return response()->json(['message' => 'you exceed your Points need to order more Loyalty Stars'], 422); // Ayusin ang maximum limit at HTTP status code

        }
        // Check if customer_card_num exists in CardCodes with status 0
        $cardCode = CardCode::where('card_number', $validated['card_number'])
            ->where('status', 1)
            ->first();
        if (!$cardCode) {
            return response()->json(['message' => 'Card Number is not yet registered'], 422); // Ayusin ang maximum limit at HTTP status code

        }
            Point::create([
                'user_id' => $user->id,
                'card_number' => $validated['card_number'],
                'product_price' => $validated['price'],
                'points' => $validated['points'],
            ]);

            $merchant->merchant->update(['stars_points' => $points]);


            $user = Auth::user();
            activity()
                ->performedOn($user)
                ->causedBy($user)
            ->withProperties(['role' => $user->role, 'status' => $user->status])
                ->log("$user->fname $user->lname added $validated[points] points to $cardCode->card_number");
        return response()->json(['message' => 'Start Points Added Successfully']);
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
