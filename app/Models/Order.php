<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'billing_name',
        'billing_address',
        'billing_city',
        'billing_county',
        'billing_country',
        'billing_vat_number',
        'payment_method',
        'status',
        'total',
        'hash',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
