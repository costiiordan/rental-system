<?php

namespace App\Repository;

use App\Models\Constants\PriceDurationType;
use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class ItemRepository
{
    private const DAY_IN_HOURS = 8;

    public function getAvailableItems(): Collection
    {
        $items = Item::with(['attributeValues.attribute', 'prices'])->get();

        return $items;
    }

    public function calculatePriceForItem(Item $item, Carbon $from, Carbon $to): int
    {
        $durationUnit = PriceDurationType::DAY;
        $duration = $from->diffInDays($to);

        if ($duration < 1) {
            $duration = $from->diffInHours($to);
            $durationUnit = PriceDurationType::HOUR;
        }

        if ($durationUnit === PriceDurationType::DAY) {
            $duration = ceil($duration);
        }

        $prices = [];

        foreach ($item->prices as $price) {
            if ($durationUnit === PriceDurationType::DAY) {
                if ($price->duration_unit === PriceDurationType::DAY) {
                    $prices[] = $price->duration > $duration ?
                        $price->price :
                        $price->price * ceil($duration / $price->duration);

                    continue;
                }

                if ($price->duration_unit === PriceDurationType::HOUR) {
                    $durationInHours = $duration * self::DAY_IN_HOURS;
                    $prices[] = $price->duration > $durationInHours ?
                        $price->price :
                        $price->price * ceil($durationInHours / $price->duration);

                    continue;
                }
            }

            if ($durationUnit === PriceDurationType::HOUR) {
                if ($price->duration_unit === PriceDurationType::DAY) {
                    $prices[] = $price->price;

                    continue;
                }
                if ($price->duration_unit === PriceDurationType::HOUR) {
                    $prices[] = $price->duration > $duration ?
                        $price->price :
                        $price->price * ceil($duration / $price->duration);

                    continue;
                }
            }
        }

        return min($prices);
    }

    public function getPricesForItems(Collection $items, Carbon $from, Carbon $to): array
    {
        $prices = [];

        foreach ($items as $item) {
            $prices[$item->id] = $this->calculatePriceForItem($item, $from, $to);
        }

        return $prices;
    }
}
