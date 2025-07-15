<?php

namespace App\Services;

use App\Dto\IntervalDto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DateIntervalService
{
    protected ?IntervalDto $interval;

    public function __construct(Request $request)
    {
        $this->initInterval($request);
    }

    public function getInterval(): ?IntervalDto
    {
        return $this->interval;
    }

    private function initInterval(Request $request): void
    {
        $this->interval = null;

        $from = $this->getDateTime($request->get('from_date'), $request->get('from_time'));
        $to = $this->getDateTime($request->get('to_date'), $request->get('to_time'));

        if (!$from || !$to) {
            return;
        }

        $fromCarbon = Carbon::createFromFormat('Y-m-d H:i', $from);
        $toCarbon = Carbon::createFromFormat('Y-m-d H:i', $to);

        if ($fromCarbon->greaterThanOrEqualTo($toCarbon)) {
            $temp = $fromCarbon;
            $fromCarbon = $toCarbon;
            $toCarbon = $temp;
        }

        $this->interval = new IntervalDto([
            'from' => $fromCarbon,
            'to' => $toCarbon,
        ]);
    }

    private function getDateTime(?string $date, ?string $time): ?string
    {
        if (!$date || !$time) {
            return null;
        }

        return $date . ' ' . $time;
    }
}
