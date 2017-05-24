<?php

namespace App\Http\Controllers\Volunteer;

use App\Model\Volunteer\Location;
use App\Model\Volunteer\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //
    /**
     * Handles requests to rmscvol.com/
     * Displays the standard login page, maybe with some errors if they've been redirected back here
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View - The standard login page view
     */
    public function loginPage()
    {
        // If the user returned here and was logged in, we need to delete their session
        session()->forget('volunteer-logged-in');

        if (Auth::user()) {
            Auth::logout();
        }

        return view('login.home-login');
    }

    /**
     * If the user gets here, means they're verified and we take them to the volunteer profile
     *
     * @param Request $request - The form data containing the badge # from login form
     * @return mixed
     */
    public function loginCheck(Request $request)
    {
        // Checks to see if the badge is a valid #, then redirects if no/yes
        if (! Volunteer::where('badge', '=', $request->badge)->exists()) {
            // If we have an unknown badge and are on-location, allow them to create a new one
            if (Location::where('ip_address', '=', $request->ip_address)->exists()) {
                return redirect()->action('Admin\AdminController@newBadge', ['badge' => $request->badge]);
            }
            // Else back to the login page with an error message
            return redirect()->route('new-badge', ['id' => 1]);
        }

        // Now we know we have a volunteer so we can store their info
        $volunteer = Volunteer::where('badge', '=', $request->badge)->first();

        // Some volunteers have to be location limited, so we check if they need to be and are on location
        if ($volunteer->isLocationLimited()
            && !Location::where('ip_address', '=', $request->ip_address)->exists()) {
            return redirect()->action('Volunteer\LoginController@loginFailure', ['id' => 3]);
        }

        session()->put('volunteer-logged-in', $volunteer);
        return redirect()->action('Volunteer\VolunteerController@profile');
    }

    /**
     * This function will handle redirecting to the login page after a login failure, or
     * other conditions that would lead to a user being redirected back to the homepage.
     *
     * @param $id - The id # of the error message we'll display to the user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector - always redirects to homepage
     */
    public function loginFailure($id)
    {
        $message = '';
        switch ($id) {
            case 1:
                $message = 'Please enter a badge number.';
                break;
            case 2:
                $message = 'You must re-enter your badge number to access that page.';
                break;
            case 3:
                $message = 'You must log in from an approved location.';
                break;
        }

        session()->flash('login-status', $message);
        return redirect('/');
    }


}
