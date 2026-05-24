<?php

namespace App\Models;

use App\Models\Constants\AttributeReference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

class Item extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = ['name', 'category_id', 'description', 'sku', 'status', 'image_path', 'order'];

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValues::class, 'item_attribute_value', 'item_id', 'attribute_value_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ItemPrices::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(ItemBooking::class);
    }

    public function category(): ?AttributeValues
    {
        foreach ($this->attributeValues as $attributeValue) {
            if ($attributeValue->attribute->reference === AttributeReference::CATEGORY) {
                return $attributeValue;
            }
        }

        return null;
    }

    /**
     * @return AttributeValues[]
     */
    public function nonCategoryAttributeValues(): array
    {
        $attributes = [];

        foreach ($this->attributeValues as $attributeValue) {
            if ($attributeValue->attribute->reference === AttributeReference::CATEGORY) {
                continue;
            }

            $attributes[] = $attributeValue;
        }

        return $attributes;
    }

    public function isAvailableInInterval(Carbon $fromDate, Carbon $toDate): bool
    {
        $isIntervalInLockedDays = LockedDay::whereIn('date', [
                $fromDate->format('Y-m-d'),
                $toDate->format('Y-m-d'),
            ])->exists();

        if ($isIntervalInLockedDays) {
            return false;
        }

        return !$this->bookings()
            ->where('from_date', '<', $toDate)
            ->where('to_date', '>', $fromDate)
            ->exists();
    }
}
