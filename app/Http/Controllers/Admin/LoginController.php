<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Displays the admin login page
     */
    public function loginPage()
    {
        // If the user returned here and was logged in, we need to delete their session
        session()->forget('admin-logged-in');
        return view('login.admin-login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector will check if success login
     */
    public function loginCheck()
    {
        return redirect('admin/home');
    }

}
