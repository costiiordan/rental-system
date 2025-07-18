<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GoogleIconImport extends Component
{
    private const array ICONS = [
        'phone_enabled',
        'search',
        'shopping_cart',
        'stat_1',
        'check_circle',
        'chevron_backward',
        'language',
        'location_on',
        'mail',
        'menu',
        'close',
        'sentiment_dissatisfied',
        'schedule',
    ];

    public function render(): View
    {
        return view('components.google-icon-import')->with([
            'icons' => collect(self::ICONS)->sort()->values()->join(','),
        ]);
    }
}
