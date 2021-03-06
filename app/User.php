<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * Class User
 * @package App
 */
class User extends Model
{
    protected $appends = [
        'full_name'
    ];

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'password',
    ];

    public function getFullNameAttribute($pass)
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
