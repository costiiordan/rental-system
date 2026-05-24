<?php

declare(strict_types=1);

namespace App\View\Components;

trait IntervalParams
{
    protected function getIntervalParams(): array
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
