<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(){

        // return Customer::latest()->get();
        $searchFields = ['customer_card_num', 'fname', 'mname', 'lname',  'contact', 'email', 'zip', 'street', 'city', 'province', ];
        $customer = Customer::query()
        ->where('status', 1)
        ->when(request('query'), function ($query, $searchQuery) use ($searchFields){
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
        ]);

    return response()->json(['message' => 'success']);
        
    }

    public function edit(Customer $customer){

        return $customer;
        // return response()->json($customer);
        
    }

    public function update(Request $request, Customer $customer){

        $validate = $request->validate([
            'customer_card_num' => 'required', 
            'mname' => '', 
            'fname' => 'required', 
            'lname' => 'required',
            'contact' => 'required',
            'bdate' => '', 
            'email' => 'required|unique:users,email,'.$customer->user->id,
            'zip' => '', 
            'street' => '', 
            'city' => '', 
            'province' => '', 

        ]);

        $customer->update($validate);

        return response()->json(['success' => true]);

    }
}
