<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function authentications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->passes()) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $role = $user->role; // Assuming your user model has a 'role' attribute
                return response()->json(['message' => 'Login successful', 'role' => $role], 200);
            } else {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } else {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return response()->json(['message'=> 'Logged out successfully'], 200);
    }
}
