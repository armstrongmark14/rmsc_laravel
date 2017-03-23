<?php

namespace App\Model\Volunteer;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $fillable = ['name'];

    /**
     * Will return an array of volunteers with that type_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany - Array of volunteers of that type
     */
    public function volunteers()
    {
        return $this->hasMany('App\Model\Volunteer\Volunteer');
    }


}
