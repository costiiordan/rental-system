<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBooking extends Model
{
    protected $fillable = [
        'item_id',
        'order_id',
        'from_date',
        'to_date',
    ];
    public $timestamps = false;
}
