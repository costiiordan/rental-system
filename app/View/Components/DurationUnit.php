<?php

namespace App\View\Components;

use App\Models\Constants\PriceDurationType;
use Illuminate\View\Component;

class DurationUnit extends Component
{
    public function __construct(public string $durationUnit, public string $duration)
    { }

    public function render(): string
    {
        return match ($this->durationUnit) {
            PriceDurationType::DAY => $this->duration > 1 ? __('zile') : __('zi'),
            PriceDurationType::HOUR => $this->duration > 1 ? __('ore') : __('oră'),
        };
    }
}
