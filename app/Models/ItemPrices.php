<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemPrices extends Model
{
    protected $fillable = ['item_id', 'duration', 'duration_unit', 'price'];
    public $timestamps = false;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
