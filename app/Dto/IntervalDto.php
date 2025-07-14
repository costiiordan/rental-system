<?php

namespace App\Dto;

use Illuminate\Support\Carbon;

class IntervalDto
{
    public Carbon $from;
    public Carbon $to;

    public function __construct(array $data)
    {
        $this->from = Carbon::parse($data['from']);
        $this->to = Carbon::parse($data['to']);
    }
}
