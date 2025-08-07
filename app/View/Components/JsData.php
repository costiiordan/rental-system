<?php

namespace App\View\Components;

use App\Repository\CartRepository;
use App\Services\DateIntervalService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JsData extends Component
{
    public function __construct(
        private CartRepository $cartRepository,
        private DateIntervalService $dateIntervalService,
    ) { }

    public function render(): View
    {
        $cart = $this->cartRepository->getCart();

        return view('components.js-data', [
            'cart' => $cart,
            'interval' => $this->dateIntervalService->getInterval(),
        ]);
    }
}
