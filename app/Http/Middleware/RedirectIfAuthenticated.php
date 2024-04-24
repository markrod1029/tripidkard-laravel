<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {

        if (Auth::guard($guard)->check()) {
            // If authenticated, redirect based on user's role
            $role = Auth::user()->role;
            if ($role === 'Merchant') {
                return redirect('/merchant/dashboard');
            } elseif ($role === 'Enterprise') {
                return redirect('/enterprise/dashboard');
            } elseif ($role === 'Admin') {
                return redirect('/admin/dashboard');
            }
        }
        return $next($request);
    }
}
