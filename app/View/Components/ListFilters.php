<?php

namespace App\View\Components;

use App\Services\CategoryFilterService;
use App\Services\DateIntervalService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListFilters extends Component
{
    public function __construct(
        private DateIntervalService $dateIntervalService,
        private CategoryFilterService $categoryFilterService,
    ) { }


    public function render(): View
    {
        $category = $this->categoryFilterService->getCategory();
        $interval = $this->dateIntervalService->getInterval();

        $urlParams = [];

        if ($category !== null) {
            $urlParams['category'] = $category->reference;
        }

        if ($interval !== null) {
            $urlParams['from_date'] = $interval->from->format('Y-m-d');
            $urlParams['from_time'] = $interval->from->format('H:i');
            $urlParams['to_date'] = $interval->to->format('Y-m-d');
            $urlParams['to_time'] = $interval->to->format('H:i');
        }

        $removeCategoryUrl = route('home', array_filter(
            $urlParams,
            fn($value, $key) => $key !== 'category', ARRAY_FILTER_USE_BOTH)
        );

        $removeIntervalUrl = route('home', array_filter(
            $urlParams,
            fn($value, $key) => !in_array($key, ['from_date', 'from_time', 'to_date', 'to_time']), ARRAY_FILTER_USE_BOTH)
        );

        return view('components.list-filters')->with([
            'interval' => $interval,
            'category' => $category,
            'removeCategoryUrl' => $removeCategoryUrl,
            'removeIntervalUrl' => $removeIntervalUrl,
        ]);
    }
}
