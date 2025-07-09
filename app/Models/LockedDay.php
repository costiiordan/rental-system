<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LockedDay extends Model
{
    protected $fillable = ['date'];
    public $timestamps = false;
}
