<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
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
        $tripidkards = Discount::query()
        ->select('discounts.id AS discount_id', 'discounts.*', 'customers.*')
            ->leftJoin('customers', 'discounts.card_number', '=', 'customers.customer_card_num')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('discounts.user_id', '=', $user->id)
            ->get();
        return response()->json($tripidkards);
    }

}
