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

    public function render(): View
    {
        $interval = $this->dateIntervalRepository->getInterval();

        if ($interval) {
            $fromDate = $interval->from->format('Y-m-d');
            $fromTime = $interval->from->format('H:i');
            $toDate = $interval->to->format('Y-m-d');
            $toTime = $interval->to->format('H:i');
        } else {
            $fromDate = now()->format('Y-m-d');
            $fromTime = '09:00';
            $toDate = now()->addDay()->format('Y-m-d');
            $toTime = '18:00';
        }

        return view('components.range-selector')->with([
            'fromDate' => $fromDate,
            'fromTime' => $fromTime,
            'toDate' => $toDate,
            'toTime' => $toTime,
            'category' => $this->categoryFilterService->getCategory(),
        ]);
    }
}
