<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Volunteer\Volunteer;
use Symfony\Component\HttpFoundation\Session\Session;

class VolunteerMiddleware
{
    /**
     * Handle an incoming request.
     * Takes in a badge number, and will put them back to the homepage if it is incorrect.
     * If correct, will take them to rmscvol.com/volunteer
     * The profile of the badge that was entered
     *
     * @param  \Illuminate\Http\Request  $request - The request containing form data
     * @param  \Closure  $next - No idea what this is
     * @return mixed - If successful, will pass this request along to the route that was intended
     */
    public function handle($request, Closure $next)
    {
        $volunteer = Volunteer::where('badge', $request->badge)->first();
        if ($volunteer == null) {
            $request->session()->flash('login-status', 'Please enter a correct badge number.');
            return redirect('/');
        }

        return $next($request);
    }
}
