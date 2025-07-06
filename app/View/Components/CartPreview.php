<?php

namespace App\View\Components;

use App\Repository\CartRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartPreview extends Component
{
    public function __construct(private CartRepository $cartRepository)
    { }

    public function render(): View|Closure|string
    {
        $cart = $this->cartRepository->getCart();

        return view('components.cart-preview', ['cart' => $cart]);
    }
}
