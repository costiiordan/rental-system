<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
