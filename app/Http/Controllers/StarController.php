<?php

namespace App\Http\Controllers;

use App\Models\Star;
use Illuminate\Http\Request;
use App\Mail\OrderPointEmail;
use Illuminate\Support\Facades\Mail;

class StarController extends Controller
{

    public function sendStarPoint(Request $request) {
        $validated = $request->validate([
            'starsPoints' => 'required',
        ]);

        $email = auth()->user()->email;
        $subject = 'Request to Purchase Start Points';
        $totalStarPoints = $validated['starsPoints'];
        $message = "I would like to inquire about purchasing start points. Please provide me with the details and process for acquiring them.\n\n";

        // Send email
        Mail::to('aeon.redstone@gmail.com', $email)->send(new OrderPointEmail($message, $subject, $email, $totalStarPoints)); // Pass the totalStarPoints

        return response()->json(['message' => 'Order Star Point email sent successfully.'], 200);
    }


}
