<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    public $timestamps = true;

    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function roledBy()
    {
        return $this->belongsTo('Role', 'role_id');
    }

    public function images()
    {
        return $this->hasMany('Image');
    }

    public function hasManyAdministrators()
    {
        return $this->hasMany('Administrator');
    }

    public function hasManyParticulars()
    {
        return $this->hasMany('Particular');
    }

    public function hasManyShelter()
    {
        return $this->hasMany('Shelter');
    }
}
