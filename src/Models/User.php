<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    //   protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }
}