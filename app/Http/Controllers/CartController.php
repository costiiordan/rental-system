<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemoveCartItemRequest;
use App\Http\Requests\AddToCartRequest;
use App\Repository\CartRepository;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function addItem(AddToCartRequest $request, CartRepository $cartRepository): JsonResponse
    {
        $validated = $request->validated();

        $cartItemId = $cartRepository->addItem($validated);

        return response()->json([
            'cart' => $cartRepository->getCart()->toArray(),
            'cartItemId' => $cartItemId,
        ]);
    }

    public function removeItem(RemoveCartItemRequest $request, CartRepository $cartRepository): JsonResponse
    {
        $cartRepository->removeItem($request->post('id'));

        return response()->json([
            'cart' => $cartRepository->getCart()->toArray(),
        ]);
    }
}
