<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValues::class);
    }
}
