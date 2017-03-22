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

    public function badge()
    {
        return $this->belongsTo('App\Model\Volunteer\Badge');
    }

    public function type()
    {
        return $this->belongsTo('App\Model\Volunteer\Type');
    }

    public function department()
    {
        return $this->belongsTo('App\Model\Volunteer\Department');
    }

    public function photo()
    {
        return $this->belongsTo('App\Model\Volunteer\Photo');
    }
}
