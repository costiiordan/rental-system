<?php

namespace App\View\Components;

use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class Duration extends Component
{
    public function __construct(public Carbon $from, public Carbon $to)
    { }

    public function render(): string
    {
        $durationInDays = $this->from->diffInDays($this->to);
        $durationInHours = $this->from->diffInHours($this->to);

        if ($durationInDays < 1 && $durationInHours < 8) {
            return $durationInHours . ($durationInHours > 1 ? ' '.__('ore') : ' '.__('oră'));
        }

        return  $durationInDays > 1 ? ceil($durationInDays).' '.__('zile') : '1 '.__('zi');
    }
}
