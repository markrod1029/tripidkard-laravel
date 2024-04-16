<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CardCode;
use Illuminate\Http\Request;

class CardCodeController extends Controller
{
    public function index()
    {
        $searchFields = [
            'enterprises.business_code',
            'merchants.business_code',
            'card_codes.card_code',
            'card_codes.business_name',
            // 'card_codes.validity',
        ];

        $tripidkards = User::query()
            ->leftJoin('card_codes', 'card_codes.user_id', '=', 'users.id')
            ->leftJoin('merchants', 'merchants.user_id', '=', 'users.id')
            ->leftJoin('enterprises', 'enterprises.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('card_codes.status', '=', 0)
            ->get();

        return response()->json($tripidkards);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'tripidkard_number' => 'required|numeric', // Example validation rule, adjust as needed
            'enterprise_id' => 'required', // Ensure enterprise is selected
            'merchant_id' => 'required', // Ensure merchant is selected
            // Add more validation rules as needed
        ]);

        // Retrieve current user
        $user = $request->user();

        // Check if the selected enterprise is "None"
        if ($request->input('enterprise_id') === 'None') {
            // If enterprise is "None", use merchant_id as user_id
            $user_id = $request->input('merchant_id');
        } else {
            // If enterprise is selected, use enterprise_id as user_id
            $user_id = $request->input('enterprise_id');
        }

        // Calculate the expiry date
        $expiryDate = Carbon::now()->addYear()->addMonths(3); // 1 year and 3 months from now


        // Retrieve the number of tripidkards to generate
        $numberOfTripidkards = $request->input('tripidkard_number');

        // Loop to generate multiple customer codes
        for ($i = 0; $i < $numberOfTripidkards; $i++) {
            $cardNumber = $this->generateCardCode();

            CardCode::create([
                'user_id' => $user_id, // Use enterprise_id or merchant_id as user_id
                'card_number' => $cardNumber,
                'status' => 0,
                'validity' => $expiryDate->format('Y-m-d'),
            ]);
        }

        // Optionally, you can return a response or redirect the user
        return response()->json(['message' => 'Tripidkards generated successfully']);
    }

    public function generateCardCode()
    {
        $currentYear = date('Y');
        $lastCardCode = CardCode::where('card_number', 'like', $currentYear . '-%')->latest('card_number')->value('card_number');
        $lastSerialNumber = 1;
        if ($lastCardCode) {
            $lastSerialNumber = intval(substr($lastCardCode, -7)) + 1;
        }
        return $currentYear . '-0C-' . str_pad($lastSerialNumber, 7, '0', STR_PAD_LEFT);
    }
}
