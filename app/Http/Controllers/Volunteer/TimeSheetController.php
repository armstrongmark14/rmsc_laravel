<?php

namespace App\Http\Controllers\Volunteer;

use App\Model\Volunteer\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeSheetController extends Controller
{
    //

    public function clockIn()
    {
        $volId = session('volunteer-logged-in')->id;
        $time = Timesheet::now();
        Timesheet::create(['volunteer_id' => $volId, 'in' => $time, 'out' => $time]);
        $this->timeclockMessage(session('volunteer-logged-in')->first_name, 'in');
        return redirect('/');
    }

    public function clockOut()
    {
        $timesheet = session('volunteer-logged-in')->hasOpenTimesheet();
        $timesheet[1] ->clockOut(); // First entry is true/false -> second is timesheet object
        $this->timeclockMessage(session('volunteer-logged-in')->first_name, 'out');
        return redirect('/');
    }

    public function timeclockMessage($name, $message)
    {
        session()->flash('timeclock', $name . ' clocked ' . $message . ' at ' . substr(Timesheet::now(), 10, 18));
    }

    public function edit($id)
    {
        $timesheet = Timesheet::find($id);
        $volunteer = session('volunteer-logged-in');
        return view('volunteer.time.edit', compact('volunteer', 'timesheet'));
    }

    public function updateTimesheet(Request $request)
    {
        $volunteer = session('volunteer-logged-in');
        if ($volunteer->edit_time != 1) {
            session()->flash('login-status', 'You do not have access to edit timesheets.');
            redirect('/');
        }

        $timesheet = Timesheet::find($request->id);
        $date = $request->date;
        $timesheet->in = $date . ' ' . $request->in;
        $timesheet->out = $date . ' ' . $request->out;
        $timesheet->save();

        session()->flash('timeclock', 'Timesheet updated successfully.');
        return redirect('/volunteer/timesheets');
    }
}
