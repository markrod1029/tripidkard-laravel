<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
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
        Mail::to('aeon.redstone@gmail.com')->send(new ContactEmail($email, $subject, $message));

        return response()->json(['message' => 'Contact email sent successfully.'], 200);

    }
}
