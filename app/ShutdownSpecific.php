<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShutdownSpecific extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'shutdown_specific';
    protected $fillable = ['date', 'time', 'jobnumber'];
    protected $guarded = [];
}
