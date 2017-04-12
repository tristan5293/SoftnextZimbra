<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\Users', 'user_roles');
    }
    protected $primaryKey = 'id';
    protected $table = 'roles';
    protected $fillable = ['name', 'created_at', 'updated_at'];
    protected $guarded = [];
}
