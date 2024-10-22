<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        // Authenticate the user
        $request->authenticate();

        // Check if the authenticated user has a status of 1
        if (Auth::user()->status !== 1) {
            Auth::logout();
            return response()->json([
                'message' => 'Your account is not active. Please contact support.',
            ], 403); // 403 Forbidden
        }

        // Prevent Admin from logging in
        if (Auth::user()->role === 'Admin') {
            Auth::logout(); // Ensure the user is logged out
            return response()->json([
                'message' => 'These credentials do not match our records.',
            ], 403); // 403 Forbidden
        }

        // Regenerate the session to avoid session fixation
        $request->session()->regenerate();

        // Return the authenticated user data
        return response()->json([
            'user' => Auth::user(),
        ]);
    }

    public function storeAdmin(LoginRequest $request): Response
    {
        // Authenticate the user
        $request->authenticate();

        // Check if the authenticated user has a status of 1
        if (Auth::user()->status !== 1) {
            Auth::logout();
            return response()->json([
                'message' => 'Your account is not active. Please contact support.',
            ], 403); // 403 Forbidden
        }


        // Regenerate the session to avoid session fixation
        $request->session()->regenerate();

        // Return the authenticated user data
        return response()->json([
            'user' => Auth::user(),
        ]);
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();

    }
}
