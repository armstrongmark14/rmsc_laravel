<?php

namespace App\Http\Controllers\Volunteer;

use App\Model\Volunteer\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeSheetController extends Controller
{
    /**
     * Creates a new timesheet and fills it with the current time
     */
    public function clockIn()
    {
        $volId = session('volunteer-logged-in')->id;
        $time = Timesheet::now();
        Timesheet::create(['volunteer_id' => $volId, 'in' => $time, 'out' => $time]);
        $this->timeclockMessage(session('volunteer-logged-in')->first_name, 'in');
        return redirect('/');
    }

    /**
     * This will clock the volunteer out and update their latest open timesheet from today to close it at this time
     */
    public function clockOut()
    {
        $timesheet = session('volunteer-logged-in')->hasOpenTimesheet();
        $timesheet[1] ->clockOut(); // First entry is true/false -> second is timesheet object
        $this->timeclockMessage(session('volunteer-logged-in')->first_name, 'out');
        return redirect('/');
    }

    /**
     * Will be called after a volunteer clocks in or out to show them on the login page
     */
    public function timeclockMessage($name, $message)
    {
        session()->flash('timeclock', $name . ' clocked ' . $message . ' at ' . substr(Timesheet::now(), 10, 18));
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
        $this->validate($request, [
            'date' => 'required|date|min:10|max:10',
            'in' => 'required|min:8|max:8',
            'out' => 'required|min:8|max:8'
        ]);


        $volunteer = session('volunteer-logged-in');
        if ($volunteer->edit_time != 1) {
            session()->flash('login-status', 'You do not have access to edit timesheets.');
            redirect('/');
        }

        $timesheet = Timesheet::find($request->id);
        $date = $request->date;

        // Validating the date and times the user entered as valid timestamps
        // These rules aren't perfect, but they at least block letters
        // Could update later, but I doubt this feature is used much so I'll leave it at this
        if ( ! preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $date .' '. $request->in)
            || ! preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $date .' '. $request->out)) {
            session()->flash('login-status', 'You must enter a valid date and time.');
            return redirect('/volunteer/timeclock/edit-timesheet/'.$timesheet->id);
        }

        $timesheet->in = $date . ' ' . $request->in;
        $timesheet->out = $date . ' ' . $request->out;
        $timesheet->save();

        session()->flash('timeclock', 'Timesheet updated successfully.');
        return redirect('/volunteer/timesheets');
    }
}
