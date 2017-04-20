<?php

namespace App\Model\Volunteer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    //
    protected $fillable = ['volunteer_id', 'in', 'out'];

    /**
     * Useful for getting the volunteer that owns a timesheet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne - The volunteer for this timesheet
     */
    public function volunteer()
    {
        return $this->belongsTo('App\Model\Volunteer\Volunteer');
    }

    public function displayOut()
    {
        if (strcmp($this->in, $this->out) != 0) {
            return $this->out;
        }
        else {
            return "";
        }
    }

    /**
     * @return string Returns the number of hours to 2 decimals that this timesheet is for
     */
    public function hours()
    {
        $in = strtotime($this->in);
        $out = strtotime($this->out);
        return number_format(round(abs($out - $in) / 3600, 2), 2);
    }

    /**
     *  uses the timesheet object to update itself and give the clock-out time a value
     */
    public function clockOut()
    {
        $this->update(['out' => $this->now()]);
    }

    /**
     * @return static - The current timestamp from this timezone
     */
    public static function now()
    {
        return Carbon::now('America/New_York');
    }

}
