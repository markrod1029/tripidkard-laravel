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
        $searchFields = ['customer_card_num', 'fname', 'mname', 'lname', 'contact', 'email', 'zip', 'street', 'city', 'province', 'validity'];
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
        $user = auth()->user();

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
            return response()->json(['error' => 'The provided card number is not registered or is invalid.'], 400);
        }

        // Calculate the validity date (1 year and 3 months from now)
        $validityDate = now()->addMonths(15); // 15 months = 1 year and 3 months

        // Create the customer
        Customer::create([
            'user_id' => $user->id,
            'customer_card_num' => $validated['customer_card_num'],
            'fname' => $validated['fname'],
            'mname' => $request->input('mname'),
            'lname' => $validated['lname'],
            'contact' => $validated['contact'],
            'bdate' => $request->input('bdate'),
            'email' => $validated['email'],
            'zip' => $request->input('zip'),
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'status' => 1,
            'validity' => $validityDate,
        ]);

        // Update the card code status to 1
        $cardCode->update(['status' => 1, 'validity' => $validityDate,]);

        return response()->json(['success' => 'Customer added successfully']);
    }


    public function edit(Customer $customer)
    {

        return $customer;
        // return response()->json($customer);

    }

    public function update(Request $request, Customer $customer)
    {

        $validated = $request->validate([
            'mname' => '',
            'fname' => 'required',
            'lname' => 'required',
            'contact' => 'required',
            'bdate' => '',
            'email' => 'required|unique:users,email,' . $customer->id,
            'zip' => '',
            'street' => '',
            'city' => '',
            'province' => '',

        ]);

        $customer->update($validated);


        return response()->json(['success' => true]);

    }

    public function count()
    {

        $user = auth()->user(); // Get the authenticated user

        if ($user->role === 'Admin') {
            // Admin counts all customers
            $customerCount = Customer::where('status', 1)->count();

        } elseif ($user->role === 'Merchant') {
            // Merchant counts only their own customers
            $customerCount = Customer::where('status', 1)
                ->where('user_id', $user->id) // Assuming you have a foreign key linking customers to merchants
                ->count();
        } elseif ($user->role === 'Influe  ncer') {
            // Influencer counts only their own customers
            $customerCount = Customer::where('status', 1)
                ->where('user_id', $user->id) // Assuming you have a foreign key linking customers to influencers
                ->count();
        } else {
            // If the role doesn't match, return 0 or an appropriate message
            $customerCount = 0; // or return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['count' => $customerCount]);
    }

}
