<?php

namespace App\Http\Middleware;
use App\User;
use Illuminate\Support\Facades\Auth;

use Closure;

class SuperAdminMiddleware
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


        if (Auth::user()->permission->level != 1337) {
            // Redirect to login if there is no user
            session()->flash('admin-error', 'Sorry, you lack privileges for that page.');
            return redirect('/admin/home');
        }
        else {
            return $next($request);
        }
    }
}
