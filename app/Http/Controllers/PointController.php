<?php

namespace App\Http\Controllers;

use App\Models\CardCode;
use App\Models\User;
use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{

    public function merchantIndex(Request $request)
    {

        $user = request()->user();
        $user_id = $request->route('user_id');
        dd($user_id);
        $searchFields = [
            'points.card_number',
            'customers.fname',
            'customers.mname',
            'customers.lname',
            'points.product_code',
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

        $validated = $request->validate([
            'card_number' => 'required',
            'product_code' => 'required',
            'price' => 'required',
            'points' => 'required',
        ]);

        // Check if customer_card_num exists in CardCodes with status 0
        $cardCode = CardCode::where('card_number', $validated['card_number'])
            ->where('status', 1)
            ->first();

        if (!$cardCode) {

        } else {
            Point::create([
                'user_id' => $user->id,
                'card_number' => $validated['card_number'],
                'product_code' => $validated['product_code'],
                'product_price' => $validated['price'],
                'points' => $validated['points'],
            ]);

        }
        return response()->json(['message' => 'success']);
    }

    public function edit(Point $point) {
        return $point;

    }

    public function update(Request $request, Point $point) {

        $validated = $request->validate([
            'points' => 'required',
        ]);

        $point->update($validated);
        return response()->json(['success' => true]);

    }
}
