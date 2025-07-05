<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class DateInterval extends Component
{
    public function __construct(public Carbon $from, public Carbon $to)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->from->isSameDay($this->to)) {
            return $this->from->format('d.m.Y H:i') . ' - ' . $this->to->format('H:i');
        }

        return $this->from->format('Y.m.d H:i') . ' - ' . $this->to->format('Y.m.d H:i');
    }
}
