<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CardCodesController;
use App\Models\CardCode; // Import ng CardCode model

class CustomerController extends Controller
{

    public function index()
    {

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

            ->latest()->get();

        return response()->json($customer);

    }

    public function indexUser()
    {
        // Get the user_id of the current user
        $merchant_id = request()->user()->id;
        // Define the fields you want to search in the customers table
        $searchFields = [
            'customers.customer_card_num',
            'customers.fname',
            'customers.mname',
            'customers.lname',
            'customers.contact',
            'customers.email',
            'customers.zip',
            'customers.street',
            'customers.city',
            'customers.province',
            'customers.validity'
        ];

        // Query customers with their associated card_codes
        $customers = Customer::query()
            ->join('card_codes', 'customers.customer_card_num', '=', 'card_codes.card_number') // Join with card_codes table
            ->where('customers.status', 1) // Only active customers
            ->where('card_codes.user_id', $merchant_id) // Filter by the user's ID
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->latest('customers.created_at') // Sort by creation date
            ->select('customers.*') // Select only the customer fields
            ->get();

        return response()->json($customers); // Return the customers as JSON
    }




    public function points($id)
    {
        $searchFields = ['customer_card_num', 'fname', 'mname', 'lname', 'points', 'points.created_at'];

        $points = Point::query() // Use Point::query() as the primary model
            ->select('customers.id as customer_id', 'customers.*', 'points.created_at as point_created_at', 'points.*') // Alias 'customers.id' as 'customer_id'
            ->leftJoin('customers', 'customers.customer_card_num', '=', 'points.card_number') // Join with customers table
            ->where('customers.status', 1) // Check status on customers table
            ->where('customers.id', $id) // Filter by customer_id in points table
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->orderBy('points.created_at', 'desc') // Order by points.created_at
            ->get();

        return response()->json($points);
    }

    public function customerResult($cardNumber)
    {
        // Fetch the card_number from the request
        $cardNumber = request('card_number');

        // Retrieve the customer's details and total points
        $customerData = Customer::query()
            ->select(
                'customers.id as customer_id',
                'customers.fname', // Include necessary fields from customers
                'customers.mname', // Include necessary fields from customers
                'customers.lname', // Include necessary fields from customers
                'customers.email', // Include necessary fields from customers
                'customers.validity', // Include necessary fields from customers
                'customers.customer_card_num',
                // Add all other necessary fields from the customers table
                DB::raw('IFNULL(SUM(points.points), 0) as total_points')
            )
            ->leftJoin('points', 'customers.customer_card_num', '=', 'points.card_number') // Join with points table
            ->where('customers.status', 1) // Check status on customers table
            ->where('customers.customer_card_num', $cardNumber) // Filter by customer card number
            ->groupBy('customers.id', 'customers.fname', 'customers.mname', 'customers.lname', 'customers.email', 'customers.validity', 'customers.customer_card_num') // Group by all selected columns
            ->first(); // Get the first result

        // Check if customer exists
        if (!$customerData) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json($customerData);
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
        } elseif ($user->role === 'Merchant' || $user->role === 'Influencer') {
            // Merchant or Influencer counts only their own customers
            $customerCount = Customer::join('card_codes', 'customers.customer_card_num', '=', 'card_codes.card_number')
                ->where('customers.status', 1)
                ->where('card_codes.user_id', $user->id) // Filter by the user's ID
                ->count();
        } else {
            // If the role doesn't match, return 0 or an appropriate message
            $customerCount = 0; // or return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['count' => $customerCount]);
    }

}
