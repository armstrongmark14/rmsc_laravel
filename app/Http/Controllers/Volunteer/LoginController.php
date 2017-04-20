<?php

namespace App\Http\Controllers\Volunteer;

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
        session()->forget('admin-logged-in');

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
        if (! $volunteer = Volunteer::find($request->badge)) {
            return redirect()->action('Volunteer\LoginController@loginFailure', ['id' => 1]);
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
        }

        session()->flash('login-status', $message);
        return redirect('/');
    }


}
