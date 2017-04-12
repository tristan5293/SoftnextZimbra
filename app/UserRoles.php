<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_roles';
    protected $fillable = array('users_id', 'roles_id', 'created_at', 'updated_at');
    protected $guarded = [];
}
