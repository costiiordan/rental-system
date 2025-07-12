<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];
    protected $fillable = ['name', 'reference'];
    public $timestamps = false;

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValues::class);
    }
}
