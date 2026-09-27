<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() && ! $request->session()->has('admin_profile')) {
            return redirect()->route('home');
        }

        if (! $request->user()?->is_admin && $request->session()->get('admin_profile.is_admin') !== true) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
