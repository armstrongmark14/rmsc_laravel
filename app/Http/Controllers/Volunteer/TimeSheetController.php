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
}
