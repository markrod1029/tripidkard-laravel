<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Mail\OrderCardEmail;
use Illuminate\Http\Request;
use App\Mail\OrderPointEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendContactUs(Request $request) {

        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $email = $validated['email'];
        $subject = $validated['subject'];
        $message = $validated['message'];

        // Send email
        Mail::to('aeon.redstone@gmail.com')->send(new ContactEmail($message, $subject, $email));

        return response()->json(['message' => 'Contact email sent successfully.'], 200);

    }

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

    public function sendCard(Request $request) {
        $validated = $request->validate([
            'card_types' => 'required',
            'total' => 'required',
        ]);

        $email = auth()->user()->email;
        $subject = 'Inquiry about Purchasing Tripidkard';
        $total = $validated['total'];
        $card_types = $validated['card_types'];
        $message = "I would like to inquire about purchasing Tripidkard cards.\n\n";
        $message .= "Card Type: " . $card_types . "\n";
        $message .= "Total Cards: " . $total . "\n\n";
        $message .= "Thank you.";

        // Send email
        Mail::to('aeon.redstone@gmail.com', $email)
            ->send(new OrderCardEmail($message, $subject, $email, $total, $card_types));

        return response()->json(['message' => 'Order Card email sent successfully.'], 200);
    }

}
