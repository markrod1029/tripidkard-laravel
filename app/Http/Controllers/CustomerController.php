<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CardCode; // Import ng CardCode model
use App\Http\Controllers\CardCodesController;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {

        // return Customer::latest()->get();
        $searchFields = ['customer_card_num', 'fname', 'mname', 'lname', 'contact', 'email', 'zip', 'street', 'city', 'province',];
        $customer = Customer::query()
            ->where('status', 1)
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            // ->when(request('query'), function ($query, $searchQuery) {
            //     $query->where('fname', 'like', "%{$searchQuery}%");
            // })
            ->latest()->get();

        return response()->json($customer);

    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'customer_card_num' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:users,email',
        ]);

        // Check if customer_card_num exists in CardCodes with status 0
        $cardCode = CardCode::where('card_number', $validated['customer_card_num'])
            ->where('status', 0)
            ->first();

        // If no card code found or status is not 0, return error
        if (!$cardCode) {
        }


        Customer::create([
            'customer_card_num' => $validated['customer_card_num'],
            'fname' => $validated['fname'],
            'mname' => request('mname'),
            'lname' => $validated['lname'],
            'contact' => $validated['contact'],
            'bdate' => request('bdate'),
            'email' => $validated['email'],
            'zip' => request('zip'),
            'street' => request('street'),
            'city' => request('city'),
            'province' => request('province'),
            'status' => 1,
        ]);

        CardCode::where('card_number', $validated['customer_card_num'])->update(['status' => 1]);


        return response()->json(['success' => 'Customer Updated Successfuly']);

    }

    public function edit(Customer $customer)
    {

        return $customer;
        // return response()->json($customer);

    }

    public function update(Request $request, Customer $customer)
    {

        $validated = $request->validate([
            'customer_card_num' => 'required',
            'mname' => '',
            'fname' => 'required',
            'lname' => 'required',
            'contact' => 'required',
            'bdate' => '',
            'email' => 'required|unique:users,email,' . $customer->user->id,
            'zip' => '',
            'street' => '',
            'city' => '',
            'province' => '',

        ]);

        $customer->update($validated);
    
        

        return response()->json(['success' => true]);

    }
}
