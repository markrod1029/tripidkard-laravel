<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    public function merchantQrCode(Request $request)
    {

        // Fetch the card_number from the request
        $cardNumber = $request->input('card_number');


        // Retrieve the customer based on the card_number
        $card = Customer::where('customer_card_num', $cardNumber)->first();

        if ($card !== null) {
            // If the card is found, return the card details and a success indicator
            return response()->json([
                'message' => 'Card found',
                'card_exists' => true,
                'card_number' =>$cardNumber,
            ], 200);
        } else {
            // If the card is not found, return the scanned card number and a failure indicator
            return response()->json([
                'message' => 'Card not found',
                'card_exists' => false,
                'card_number' => $cardNumber,
            ], 200);
        }
    }
}
