<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Volunteer\Timesheet;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * Will get the total hours from each day as an array of objects and sends it to the total hours chart page
     * {
     *   "day" => "DATE",
     *   "hours" => "HOURS"
     * }
     */
    public function totalHours() {
//        return Timesheet::groupBy('in')->orderBy('in', 'DESC')->get('in', 'out');
        $totalHours = DB::select(DB::raw("
            SELECT DATE(timesheets.in) as day,
                ROUND(SUM(TIMESTAMPDIFF(MINUTE, timesheets.in, timesheets.out ) / 60 ), 2) AS hours
            FROM timesheets
            GROUP BY DATE(timesheets.in)
            ORDER BY DATE(timesheets.in) ASC;"));

        return view('admin.charts.total-hours', compact('totalHours'));
    }

    /**
     * Will get the value of the volunteers here right now and total volunteers logged in today and return them
     */
    public function updateHomeVolunteerCount()
    {
        $volCount = Timesheet::where('in', '>=', Carbon::today())->whereRaw('timesheets.in = timesheets.out')->count();

        $volsToday = DB::select(DB::raw("
              SELECT COUNT(DISTINCT(volunteer_id)) as totalVols
              FROM timesheets 
              WHERE DATE(timesheets.in) = CURDATE();"));

        return $volCount . ' / ' . $volsToday[0]->totalVols;
    }

    /**
     * Gets the total hours from today and returns that number
     */
    public function updateHomeHourCount()
    {
        $todaysHours = DB::select(DB::raw("
            SELECT ROUND(SUM(TIMESTAMPDIFF(MINUTE, timesheets.in, timesheets.out ) / 60 ), 2) as hours
            FROM timesheets
            WHERE DATE(timesheets.in) = CURDATE();"));

        return $todaysHours[0]->hours;
    }

    /**
     * @return Total # of logins on the system, from all time
     */
    public function updateHomeTotalLogins()
    {
        $totalTimesheets = DB::select(DB::raw("SELECT FORMAT(COUNT(id), 0) as num_rows FROM timesheets;"));

        return $totalTimesheets[0]->num_rows;
    }

    /**
     * @return The total number of hours logged on the system
     */
    public function updateHomeTotalHours()
    {
        $totalHours = DB::select(DB::raw("
          SELECT FORMAT(SUM(TIMESTAMPDIFF(MINUTE, timesheets.in, timesheets.out) / 60), 0) as hours 
          FROM timesheets;"));
        return $totalHours[0]->hours;
    }
}
