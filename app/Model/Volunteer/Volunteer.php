<?php

namespace App\Model\Volunteer;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    //

    protected $fillable = [
        'badge_id',
        'department_id',
        'type_id',
        'photo_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'emergency_contact',
        'emergency_phone',
    ];

    /**
     * @return array - [0] is boolean value whether they have open timesheet or not
     *                 [1] is the timesheet if exists or null if it doesn't
     */
    public function hasOpenTimesheet()
    {
        $time = $this->getLatestTimesheet();
        if (strcmp($time['in'], $time['out']) == 0
            && strcmp(substr($time['in'], 0, 10), Timesheet::now()->format('Y-m-d')) == 0) {
            return [true, $time]; // Returning true and the timesheet we wanted to edit
        }
        return [false, null]; // Else return false and no timesheet
    }

    /**
     * @return the latest timesheet this volunteer has in our database
     */
    private function getLatestTimesheet()
    {
        return $this->timesheets()->orderBy('in', 'ASC')->first();
    }

    /**
     * Gets the type of this particular volunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo - The type of that volunteer
     */
    public function type()
    {
        return $this->belongsTo('App\Model\Volunteer\Type');
    }

    /**
     * Gets the department of this particular volunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo - The department of this volunteer
     */
    public function department()
    {
        return $this->belongsTo('App\Model\Volunteer\Department');
    }

    /**
     * Gets the photo for a particular volunteer - Many volunteers can have the same photo (default.png)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo - The photo for this volunteer
     */
    public function photo()
    {
        return $this->belongsTo('App\Model\Volunteer\Photo');
    }

    /**
     * Will get all the timesheets a volunteer has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany - All timesheets a volunteer has
     */
    public function timesheets()
    {
        return $this->hasMany('App\Model\Volunteer\Timesheet')->orderBy('in', 'DESC');
    }
}
