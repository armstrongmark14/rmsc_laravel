<?php

namespace App\Http\Controllers\Volunteer;

use App\Model\Volunteer\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TimeSheetController extends Controller
{
    /**
     * Creates a new timesheet and fills it with the current time
     */
    public function clockIn()
    {
        $volId = session('volunteer-logged-in')->id;
        $time = Timesheet::now()->format("Y-m-d H:i:s");
        Timesheet::create(['volunteer_id' => $volId, 'in' => $time, 'out' => $time]);
        $this->timeclockMessage('in');
        return redirect('/');
    }

    /**
     * This will clock the volunteer out and update their latest open timesheet from today to close it at this time
     */
    public function clockOut()
    {
        $timesheet = session('volunteer-logged-in')->hasOpenTimesheet();
        $timesheet[1]->clockOut();
        $this->timeclockMessage('out');
        return redirect('/');
    }

    /**
     * Will be called after a volunteer clocks in or out to show them on the login page
     */
    public function timeclockMessage($message)
    {
        $name = session('volunteer-logged-in')->first_name;
        $time = substr(Timesheet::now(),10,18);
        session()->flash('timeclock', "{$name} clocked {$message} at {$time}");
    }

    /**
     * Displays the edit timesheet page to volunteers that have access to that functionality
     */
    public function edit($id)
    {
        $timesheet = Timesheet::find($id);
        $volunteer = session('volunteer-logged-in');
        return view('volunteer.time.edit', compact('volunteer', 'timesheet'));
    }

    /**
     * When a volunteer who has privilege to update their timesheets submits one, this function will
     * 1) Check if everything is in the right format
     * 2) Update the timesheet record
     */
    public function updateTimesheet(Request $request)
    {
        $this->validateTimesheet($request);

        if (! $this->canVolunteerEditTime()) {
            return $this->accessRedirect();
        }

        if (! $this->regexTimesheet($request)) {
            return redirect('/volunteer/timeclock/edit-timesheet/' . $request->id);
        }

        $timesheet = Timesheet::find($request->id);

        $date = $request->date;
        $timesheet->in = $date . ' ' . $request->in;
        $timesheet->out = $date . ' ' . $request->out;
        $timesheet->save();

        session()->flash('timeclock', 'Timesheet updated successfully.');
        return redirect('/volunteer/timesheets');
    }

    /**
     * This will show the page some volunteers can use to create timesheets and log hours
     */
    public function createTimesheetPage()
    {
        $date = Timesheet::now();
        $volunteer = session('volunteer-logged-in');
        return view('volunteer.time.create-new', compact('volunteer', 'date'));
    }

    /**
     * Will create a timesheet for the volunteer and redirect them to their timesheet table page
     */
    public function createTimesheet(Request $request)
    {
        $this->validateTimesheet($request);

        if (! $this->canVolunteerEditTime()) {
            return $this->accessRedirect();
        }

        if (! $this->regexTimesheet($request)) {
            return redirect('/volunteer/timeclock/create-timesheet');
        }

        $date = $request->date;
        $timesheet = Timesheet::create([
            'volunteer_id' => $request->volunteerID,
                'in' =>  $date . ' ' . $request->in,
                'out' =>  $date . ' ' . $request->out
        ]);

        session()->flash('timeclock', 'Timesheet created successfully');
        return redirect('/volunteer/timesheets');
    }

    /**
     * Will validate the request to make sure the # characters match
     * @param Request $request - The timesheet edit/create form request
     */
    public function validateTimesheet(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date|min:10|max:10',
            'in' => 'required|min:8|max:8',
            'out' => 'required|min:8|max:8'
        ]);
    }

    /**
     * Check if this volunteer can edit timesheets, if they can't redirect with error
     * @param bool $failed - Whether or not the previous call has failed test
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function canVolunteerEditTime()
    {
        return session('volunteer-logged-in')->canEditTimesheets();
    }
    private function accessRedirect()
    {
        session()->flash('login-status', 'You do not have access to edit timesheets.');
        return redirect('/');
    }

    /**
     * This is my absolutely terrible regex that basically just blocks letters for now.
     * Only like 5 people use this feature so it is pretty low priority.
     * @param Request $request - The edit/create timesheet form submission
     * @return bool - Whether or not it passed my terrible regex
     */
    public function regexTimesheet(Request $request, $adminPage=false)
    {
        $date = $request->date;
        // Validating the date and times the user entered as valid timestamps
        // These rules aren't perfect, but they at least block letters
        // Could update later, but I doubt this feature is used much so I'll leave it at this
        if ( ! preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $date .' '. $request->in)
            || ! preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $date .' '. $request->out)) {

            if ($adminPage) {
//                dd($request->all());
                session()->flash('admin-error', 'You must enter a valid date and time.');
            }
            else {
                session()->flash('login-status', 'You must enter a valid date and time.');
            }
            return false;
        }
        return true;
    }

    /**
     * Allows volunteers and admins to log hours without entering start and end times
     * @param Request $request - Pass this the $request from the form submission
     * @param bool $adminVersion - Set to true to enable 24+ hour increments
     */
    public function logHours(Request $request, $adminVersion=false)
    {
        $hourLimit = 23;
        if ($adminVersion) {
            $hourLimit = 500;
        }

        $this->validate($request, [
            'date' => 'required|date|min:10|max:10',
            'hours' => 'required|numeric|between:0,'.$hourLimit,
            'minutes' => 'nullable|between:0,59|numeric'
        ]);

        if ($request->hours < 24) {
            $this->logTimesheet($request->id, $request->date, $request->hours, $request->minutes);
        }
        else {
            // This is admin page, logging more than 24 hours
            // We'll need to split this to multiple timesheets
            $hours = $request->hours;

            while($hours > 0) {
                if ($hours >= 24) {
                    $hours -= 23;
                    $this->logTimesheet($request->id, $request->date, 23, 0);
                }
                else {
                    $this->logTimesheet($request->id, $request->date, $hours, $request->minutes);
                    $hours = 0;
                }
            }
        }
    }

    /**
     * Takes in a number and returns a 2-digit number. 1 => 01, 10 => 10
     * @param $number
     * @return string
     */
    private function twoDigit($number)
    {
        return sprintf("%02d", $number);
    }

    /**
     * @param $id - The volunteer_id of the volunteer timesheet is for
     * @param $date - The date they entered
     * @param $hours - The hours this timesheet is for
     * @param null $minutes - The minutes this timesheet has
     */
    private function logTimesheet($id, $date, $hours, $minutes=null) {
        $hours = $this->twoDigit($hours);
        $minutesUsed = "00";
        if ($minutes != null) {
            $minutesUsed = $this->twoDigit($minutes);
        }

        Timesheet::create([
            'volunteer_id' => $id,
            'in' => $date . ' 00:00:00',
            'out' => $date . " {$hours}:{$minutesUsed}:00"
        ]);
    }
}
