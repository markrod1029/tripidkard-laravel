<?php

namespace App\Http\Controllers;

use App\Models\Star;
use Illuminate\Http\Request;
use App\Models\Merchant; // Import the Merchant model

class StartPointsController extends Controller
{
    public function update(Request $request){

        $validated = $request->validate([
            "id" => "required|exists:stars,id",
            "merchant" => "required",
            "starsPoints" => "",
            "otherStarsPoints" => "required_if:starsPoints,Other" // Require otherStarsPoints only if starsPoints is Other
        ]);

        // Find the Merchant model using the ID provided in the request
        $merchant = Merchant::findOrFail($validated['merchant']);
        $star = Star::findOrFail($validated['id']);

        // Determine the points based on the input
        $points = $validated['otherStarsPoints'] ?? $validated['starsPoints'];


        $newStars = $star->stars - $points ;

        $newPoints =  $merchant->stars_points + $points;

        if($points >  $star->stars){
            return response()->json(['message' => 'Stars exceeded the maximum limit '], 422); // Ayusin ang maximum limit at HTTP status code
        }

        // Update the points attribute of the merchant
        $merchant->update(['stars_points' => $newPoints]);
        $star->update(['stars' => $newStars]);

        // Optionally, you can return a response indicating success or failure
        return response()->json(['message' => 'Points updated successfully']);
    }
    public function edit(Merchant $merchant){
        return $merchant;
    }
    }
