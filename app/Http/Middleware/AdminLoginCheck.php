<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! Auth::user()) {
            // Redirect to login if there is no user
            session()->flash('login-status', 'Sorry, you must be logged in to view that page.');
            return redirect('/admin');
        }
        else {
            return $next($request);
        }

    }
}
