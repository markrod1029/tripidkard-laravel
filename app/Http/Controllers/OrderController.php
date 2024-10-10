<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $searchFields = [
            'orders.card_type',
            'orders.total',
        ];

        $tripidkardOrders = Order::query()
        ->where('status', 0)
        ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
            $query->where(function ($query) use ($searchFields, $searchQuery) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$searchQuery}%");
                }
            });
        })
        ->latest()->get();

        return response()->json($tripidkardOrders);
    }


    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'total' => 'required|numeric',
            'card_types' => 'required',

        ]);

        $user = auth()->user();

        $user_id = $user->id;
        $card_types = $validated['card_types'];
        $total = $validated['total'];

            Order::create([
                'user_id' => $user_id,
                'cards' => $card_types,
                'total' => $total,
                'status' => 0,
            ]);

        // Optionally, you can return a response or redirect the user
        return response()->json(['message' => 'Tripidkards Orders successfully']);
    }

}
