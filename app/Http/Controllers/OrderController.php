<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderCardEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{


    public function Adminindex()
    {
        $searchFields = [
            'orders.card_type',
            'orders.total',
            'merchants.business_name', // Add relevant merchant fields here
        ];

        $tripidkardOrders = Order::query()
            ->leftJoin('users', 'orders.user_id', '=', 'users.id') // Joining orders with merchants
            ->leftJoin('merchants', 'merchants.user_id', '=', 'users.id') // Joining orders with merchants
            ->where('orders.status', 0) // Only fetch pending orders
            ->where('orders.type', 'Points') // Only fetch pending orders
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->select('orders.*', 'orders.id AS order_id', 'merchants.business_name','merchants.id as merchant_id', 'users.contact', 'users.email') // Selecting required fields
            ->latest()
            ->get();

        return response()->json($tripidkardOrders); // Return the data in JSON format
    }

    public function edit(Order $order)
    {
        // Load the related user and merchant data (business_name)
        $order->load('user.merchant');

        // Now you can access the business_name via the merchant relationship
        $businessName = $order->user->merchant->business_name;

        // Return the order along with the related user and business_name
        return response()->json([
            'order' => $order,
            'business_name' => $businessName
        ]);
    }





    // public function index()
    // {
    //     $searchFields = [
    //         'orders.card_type',
    //         'orders.total',
    //     ];

    //     $tripidkardOrders = Order::query()
    //     ->where('status', 0)
    //     ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
    //         $query->where(function ($query) use ($searchFields, $searchQuery) {
    //             foreach ($searchFields as $field) {
    //                 $query->orWhere($field, 'like', "%{$searchQuery}%");
    //             }
    //         });
    //     })
    //     ->latest()->get();

    //     return response()->json($tripidkardOrders);
    // }


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


        $subject = '';
        Mail::to('aeon.redstone@gmail.com')->send(new OrderCardEmail($subject, $card_types, $total));

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
