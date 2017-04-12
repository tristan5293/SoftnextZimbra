<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public function roles()
    {
        return $this->belongsToMany('App\Roles', 'user_roles');
    }

    protected $primaryKey = 'id';
    protected $table = 'users';
    protected $fillable = ['account', 'password', 'last_login', 'last_logout', 'created_at', 'updated_at'];
    protected $guarded = [];
}
