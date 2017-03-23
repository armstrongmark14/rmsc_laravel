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
        return $this->hasOne('App\Model\Volunteer\Volunteer');
    }

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
