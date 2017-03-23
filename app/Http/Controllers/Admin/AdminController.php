<?php

namespace App\Http\Controllers\Admin;

use App\Model\Volunteer\Timesheet;
use App\Model\Volunteer\Volunteer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //

    public function homepage()
    {
        return view('admin.home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View the view with all the volunteers
     */
    public function fullVolunteerList()
    {
        $volunteers = Volunteer::all();
        return view('admin.page.volunteer-list', compact('volunteers'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The volunteers currently here
     */
    public function currentlyHere()
    {
        $volunteers = [];
        $timesheets = Timesheet::where('in', '>=', Carbon::today())->whereRaw('timesheets.in = timesheets.out')->get();
        foreach ($timesheets as $timesheet) {
            array_push($volunteers, $timesheet->volunteer);
        }
        return view('admin.page.currently-here', compact('volunteers'));
    }
}
