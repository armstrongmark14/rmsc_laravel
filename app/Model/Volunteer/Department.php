<?php

namespace App\Model\Volunteer;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $fillable = ['name'];

    /**
     * Will return a list of volunteers the department is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany - Array of volunteers
     */
    public function volunteers()
    {
        return $this->hasMany('App\Model\Volunteer\Volunteer');
    }
}
