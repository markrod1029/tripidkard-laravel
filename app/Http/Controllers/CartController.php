<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch vouchers created by the authenticated user
        $vouchers = Cart::where('user_id', $user->id)->get();

        return response()->json($vouchers, 200);
    }

    public function store(Request $request)
    {
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
            'voucher_code' => strtoupper(Str::random(10)),
            'expires_at' => now()->addYear(),
        ]);

        return response()->json($voucher, 201);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $voucher = Cart::where('user_id', $user->id)->findOrFail($id);

        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'terms' => 'required|string',
            'points' => 'required|integer',
        ]);

        // Update the voucher details
        $voucher->update($validatedData);

        return response()->json(['voucher' => $voucher], 200);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $voucher = Cart::where('user_id', $user->id)->findOrFail($id);
        $voucher->delete();

        return response()->json(['message' => 'Voucher deleted successfully.'], 200);
    }
}
