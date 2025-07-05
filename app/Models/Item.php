<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = ['name', 'category_id', 'description', 'sku', 'status', 'image_path'];

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValues::class, 'item_attribute_value', 'item_id', 'attribute_value_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ItemPrices::class);
    }
}
