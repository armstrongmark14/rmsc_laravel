<?php

namespace App\Http\Controllers\Admin;

use App\Model\Volunteer\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //

    public function homepage()
    {
        return view('admin.home');
    }

    public function fullVolunteerList()
    {
        $volunteers = Volunteer::all();
        return view('admin.page.volunteer-list', compact('volunteers'));
    }
}
