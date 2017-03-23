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
}
