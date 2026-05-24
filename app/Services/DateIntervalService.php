<?php

namespace App\Services;

use App\Dto\IntervalDto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DateIntervalService
{
    protected ?IntervalDto $interval = null;
    protected ?string $validationError = null;

    public function __construct(Request $request)
    {
        $this->initInterval($request);
    }

    public function getInterval(): ?IntervalDto
    {
        return $this->interval;
    }

    public function getValidationError(): ?string
    {
        return $this->validationError;
    }

    private function initInterval(Request $request): void
    {
        $from = $this->getDateTime($request->get('from_date'), $request->get('from_time'));
        $to = $this->getDateTime($request->get('to_date'), $request->get('to_time'));

        if (!$from || !$to) {
            return;
        }

        $fromCarbon = Carbon::createFromFormat('Y-m-d H:i', $from);
        $toCarbon = Carbon::createFromFormat('Y-m-d H:i', $to);

        if ($fromCarbon->greaterThan($toCarbon)) {
            [$fromCarbon, $toCarbon] = [$toCarbon, $fromCarbon];
        }

        if ($fromCarbon->equalTo($toCarbon)) {
            $this->validationError = __('Selectați un interval mai mare de zero.');

            return;
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
