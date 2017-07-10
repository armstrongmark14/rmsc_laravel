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
        if ($this->loggedInCheck()) {
            return $this->backToHomepage();
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
        if ($this->loggedInCheck()) {
            return $this->backToHomepage();
        }

        $volunteer = session('volunteer-logged-in');
        $timesheets = Volunteer::find($volunteer->id)->timesheets;
        $volunteerPage = true;
        return view('volunteer.time.timesheets', compact('volunteer', 'timesheets', 'volunteerPage'));
    }

    private function loggedInCheck()
    {
        return !session()->has('volunteer-logged-in');
    }

    private function backToHomepage()
    {
        return redirect()->action('Volunteer\LoginController@loginFailure', ['id' => 2]);
    }

}
