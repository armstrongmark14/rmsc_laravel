<?php

namespace App\Http\Controllers\Volunteer;

use App\Model\Volunteer\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Volunteer\Volunteer;

class VolunteerController extends Controller
{
    //

    /**
     * Once a volunteer successfully logs in, we can store their info and send it to the view to
     * display their profile page. There they can clock in/out and view timesheets.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function profile()
    {
        if (! session()->has('volunteer-logged-in')) {
            return redirect()->action('Volunteer\LoginController@loginFailure', ['id' => 2]);
        }
        // First pulling and deleting the volunteer from the login session and moving it to the logged-in session
        $volunteer = session('volunteer-logged-in');
        $openTimesheet = $volunteer->hasOpenTimesheet();
        return view('volunteer.profile', compact('volunteer', 'openTimesheet'));
    }

    /**
     * This will get the timesheets for the volunteer and send them to the timesheets page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View goes to the volunteer timesheet page
     */
    public function viewTimesheets()
    {
        if (! session()->has('volunteer-logged-in')) {
            return redirect()->action('Volunteer\LoginController@loginFailure', ['id' => 2]);
        }
        $volunteer = session('volunteer-logged-in');
//        dd($volunteer);
        $timesheets = Volunteer::find($volunteer->id)->timesheets;
        $volunteerPage = true;
        return view('volunteer.time.timesheets', compact('volunteer', 'timesheets', 'volunteerPage'));
    }


}
