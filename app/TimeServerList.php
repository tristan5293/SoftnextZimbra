<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeServerList extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'time_server_list';
    protected $fillable = ['server_name', 'created_at', 'updated_at'];
    protected $guarded = [];
}
