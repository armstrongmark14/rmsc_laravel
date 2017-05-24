<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Displays the admin login page
     */
    public function loginPage()
    {
        // If the user returned here and was logged in, we need to delete their session
        if (Auth::user()) {
            Auth::logout();
        }

        return view('login.admin-login');
    }

    /**
     * Will check if successful login and redirect accordingly
     */
    public function loginCheck(Request $request)
    {
        try {
            $user = User::where('name', '=', $request->username)->firstOrFail();
        }
        catch (\Exception $e) {
            session()->flash('login-status', 'Please enter a valid username.');
            return redirect('/admin');
        }

        if (! $user->checkPassword($request->password)) {
            session()->flash('login-status', 'Please enter a correct password.');
            return redirect('/admin');
        }
        else {
            // Creating the Authenticated user in one step. It could possibly fail here, but shouldn't
            if (Auth::attempt(['name' => $user->name, 'password' => $request->password], true)) {
                return redirect('/admin/home');
            }

            // Redirect to login if something else went wrong
            session()->flash('login-status', 'Something went wrong. Please try again.');
            return redirect('/admin');
        }

    }

}
