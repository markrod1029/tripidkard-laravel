<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function store(Request $request) {

        $user = auth()->user();

        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'terms' => 'required|string',
            'points' => 'required|integer',
        ]);

        // Create a new voucher with a 1-year expiration date
        $voucher = Cart::create([
            'user_id' => $user->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'terms' => $validatedData['terms'],
            'points' => $validatedData['points'],
            'quantity' => 1,
            'voucher_code' => strtoupper(Str::random(10)), // Generates a unique code
            'validity' => now()->addYear(), // 1-year expiration from current date
        ]);


        return response()->json([
            'message' => 'Voucher created successfully',
            'voucher' => $voucher
        ], 201);

    }
}
