<?php

namespace App\View\Components;

use App\Models\AttributeValues;
use App\Models\Constants\AttributeReference;
use App\Models\Constants\CategoryReference;
use App\Services\DateIntervalService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CategoryNavigation extends Component
{
    private const array CATEGORY_ORDER = [
        CategoryReference::KIDS,
        CategoryReference::ENDURO_KIDS,
        CategoryReference::ELECTRIC_ENDURO,
        CategoryReference::SUPER_ENDURO_BIKE_PARK,
        CategoryReference::DOWNHILL,
        CategoryReference::ELECTRIC_MOUNTAIN_BIKE,
        CategoryReference::ROAD_GRAVEL,
        CategoryReference::GUIDE,
        CategoryReference::ACCESORIES,
    ];

    public function __construct(
        private DateIntervalService $dateIntervalService,
    ) { }

    public function render(): View
    {
        $categories = AttributeValues::query()
            ->whereHas('attribute', function ($query) {
                $query->where('reference', AttributeReference::CATEGORY);
            })
            ->get();

        $categories = $this->sortCategories($categories);

        return view('components.category-navigation')->with([
            'categories' => $categories,
            'intervalParams' => $this->getIntervalParams(),
        ]);
    }

    private function sortCategories(Collection $categories): Collection
    {
        $sortedCategories = new Collection();

        foreach (self::CATEGORY_ORDER as $categoryReference) {
            foreach ($categories as $category) {
                if ($category->reference === $categoryReference) {
                    $sortedCategories->push($category);
                    break;
                }
            }
        }

        return $sortedCategories;
    }

    private function getIntervalParams(): array
    {
        $interval = $this->dateIntervalService->getInterval();

        if ($interval === null) {
            return [];
        }

        return [
            'from_date' => $interval->from->format('Y-m-d'),
            'from_time' => $interval->from->format('H:i'),
            'to_date' => $interval->to->format('Y-m-d'),
            'to_time' => $interval->to->format('H:i'),
        ];
    }
}
