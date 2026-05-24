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
        public string $route = 'home',
        public array $routeParams = [],
        public bool $alwaysRender = false,
    ) { }

    public function render(): View|string
    {
        $interval = $this->dateIntervalRepository->getInterval();

        if ($interval && !$this->alwaysRender) {
            return '';
        }

        $fromDate = $interval?->from->format('Y-m-d') ?? now()->format('Y-m-d');
        $fromTime = $interval?->from->format('H:i') ?? '09:00';
        $toDate = $interval?->to->format('Y-m-d') ?? now()->addDay()->format('Y-m-d');
        $toTime = $interval?->to->format('H:i') ?? '17:00';

        return view('components.range-selector')->with([
            'fromDate' => $fromDate,
            'fromTime' => $fromTime,
            'toDate' => $toDate,
            'toTime' => $toTime,
            'category' => $this->categoryFilterService->getCategory(),
            'route' => $this->route,
            'routeParams' => $this->routeParams,
        ]);
    }
}
