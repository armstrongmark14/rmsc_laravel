<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = ['level'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
