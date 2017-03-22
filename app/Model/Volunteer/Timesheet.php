<?php

namespace App\Model\Volunteer;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    //
    protected $fillable = ['volunteer_id', 'in', 'out'];
}
