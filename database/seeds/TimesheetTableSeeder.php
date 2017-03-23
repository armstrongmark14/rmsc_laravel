<?php

use Illuminate\Database\Seeder;
use App\Model\Volunteer\Timesheet;

class TimesheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Timesheet::create(['volunteer_id' => 1, 'in' => '2017-01-02 12:00:00', 'out' => '2017-01-02 20:00:00']);
        Timesheet::create(['volunteer_id' => 1, 'in' => '2017-01-01 12:00:00', 'out' => '2017-01-01 15:00:00']);
        Timesheet::create(['volunteer_id' => 2, 'in' => '2017-01-04 12:00:00', 'out' => '2017-01-04 18:00:00']);
        Timesheet::create(['volunteer_id' => 2, 'in' => '2017-01-06 12:00:00', 'out' => '2017-01-06 17:00:00']);
        Timesheet::create(['volunteer_id' => 1, 'in' => '2017-01-09 12:00:00', 'out' => '2017-01-09 13:00:00']);


    }
}
