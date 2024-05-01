<?php

namespace App\Http\Controllers;

use App\Models\Merchant; // Import the Merchant model
use Illuminate\Http\Request;

class StartPointsController extends Controller
{
    public function update(Request $request){

        $validated = $request->validate([
            "merchant" => "required",
            "starsPoints" => "",
            "otherStarsPoints" => "required_if:starsPoints,Other" // Require otherStarsPoints only if starsPoints is Other
        ]);

        // Find the Merchant model using the ID provided in the request
        $merchant = Merchant::findOrFail($validated['merchant']);

        // Determine the points based on the input
        $points = $validated['otherStarsPoints'] ?? $validated['starsPoints'];

        // Update the points attribute of the merchant
        $merchant->update(['stars_points' => $points]);

        // Optionally, you can return a response indicating success or failure
        return response()->json(['message' => 'Points updated successfully']);
    }
    public function edit(Merchant $merchant){
        return $merchant;
    }
    }
