<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemBooking extends Model
{
    protected $fillable = [
        'item_id',
        'from_date',
        'to_date',
        'note',
    ];
    public $timestamps = false;

    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function orderItem(): HasOne
    {
        return $this->hasOne(OrderItem::class, 'item_booking_id', 'id');
    }
}
