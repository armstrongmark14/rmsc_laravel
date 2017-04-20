<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isSuperAdmin()
    {
        return $this->permission->level == 1337;
    }

    /**
     * Gets the permission level of this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo('App\Model\Admin\Permission');
    }


    /**
     * Will allow me to easily check the user's password myself before sending it to the Auth
     *
     * @param $password The user entered password
     * @return mixed Boolean value whether or not passwords match
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }
}
