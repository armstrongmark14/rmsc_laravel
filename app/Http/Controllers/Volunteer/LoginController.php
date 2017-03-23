<?php

namespace App\Http\Controllers\Volunteer;

use App\Model\Volunteer\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
        return view('login.home-login');
    }

    /**
     * If the user gets here, means they're verified and we take them to the volunteer profile
     *
     * @param Request $request - The form data containing the badge # from login form
     * @return mixed
     */
    public function loginSuccess(Request $request)
    {
        // Saves the badge input into a session variable and redirects to the profile
        session()->put('badge', $request->badge);
        return redirect()->action('Volunteer\LoginController@profile');

    }

    public function profile()
    {
        if (! session()->has('badge') || !$volunteer = Volunteer::find(session('badge'))) {
            session()->flash('login-status', 'Please enter a badge number.');
            return redirect('/');
        }
        session()->forget('badge');
        return view('volunteer.profile', compact('volunteer'));
    }
}
