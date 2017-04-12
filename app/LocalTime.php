<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalTime extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'local_time';
    protected $fillable = ['server_name', 'created_at', 'updated_at'];
    protected $guarded = [];
}
