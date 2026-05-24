<?php

namespace App\View\Components;

use App\Services\CategoryFilterService;
use App\Services\DateIntervalService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RangeSelector extends Component
{
    public function __construct(
        private DateIntervalService $dateIntervalRepository,
        private CategoryFilterService $categoryFilterService,
    ) { }

    public function render(): View|string
    {
        $interval = $this->dateIntervalRepository->getInterval();

        if ($interval) {
            return '';
        }

        $fromDate = now()->format('Y-m-d');
        $fromTime = '09:00';
        $toDate = now()->addDay()->format('Y-m-d');
        $toTime = '17:00';

        return view('components.range-selector')->with([
            'fromDate' => $fromDate,
            'fromTime' => $fromTime,
            'toDate' => $toDate,
            'toTime' => $toTime,
            'category' => $this->categoryFilterService->getCategory(),
        ]);
    }
}
