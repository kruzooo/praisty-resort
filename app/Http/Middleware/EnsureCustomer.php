<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->is_admin) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('guest.login')->with('account_status', 'Please sign in with a customer account before reserving a stay.');
        }

        if (! $request->user() && ! $request->session()->has('guest_profile')) {
            return redirect()->route('guest.login')->with('account_status', 'Please sign in or create a guest account before reserving a stay.');
        }

        return $next($request);
    }
}
