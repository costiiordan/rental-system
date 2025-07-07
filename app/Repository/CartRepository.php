<?php

namespace App\Repository;

use App\Dto\CartItemDto;
use App\Dto\CartDto;
use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class CartRepository
{
    public const CART_ITEMS_SESSION_KEY = 'cartItems';

    public function __construct(private ItemRepository $itemRepository)
    { }

    public function addItem(array $data): void
    {
        $cartItems = session(self::CART_ITEMS_SESSION_KEY, []);

        $bookingFromDate = Carbon::createFromFormat('Y-m-d H:i', $data['fromDate']);
        $bookingToDate = Carbon::createFromFormat('Y-m-d H:i', $data['toDate']);

        $itemIsAlreadyInCart = collect($cartItems)->contains(function ($item) use ($data, $bookingFromDate, $bookingToDate) {
            $itemFromDate = Carbon::createFromFormat('Y-m-d H:i', $item['fromDate']);
            $itemToDate = Carbon::createFromFormat('Y-m-d H:i', $item['toDate']);

            return $item['itemId'] === $data['itemId'] &&
                (
                    $bookingFromDate->isBetween($itemFromDate, $itemToDate) ||
                    $bookingToDate->isBetween($itemFromDate, $itemToDate)
                );
        });

        if ($itemIsAlreadyInCart) {
            return;
        }

        $cartItems[] = [
            'id' => uniqid(),
            'itemId' => $data['itemId'],
            'fromDate' => $data['fromDate'],
            'toDate' => $data['toDate'],
        ];

        session(['cartItems' => $cartItems]);
    }

    public function getCart(): CartDto
    {
        $cartDto = new CartDto([
            'items' => collect(),
            'discounts' => collect(),
            'total' => 0,
        ]);

        $cartDto->items = $this->getCartItems();
        $cartDto->discounts = $this->applyDiscounts($cartDto);
        $cartDto->total = $this->calculateCartTotal($cartDto);

        return $cartDto;
    }

    public function getUnavailableItems(Collection $cartItems): Collection
    {
        return $cartItems->filter(function ($cartItem) {
            return !$cartItem->item->isAvailableInInterval($cartItem->fromDate, $cartItem->toDate);
        });
    }

    public function emptyCart(): void
    {
        session()->forget(self::CART_ITEMS_SESSION_KEY);
    }

    public function removeItem(string $id): void
    {
        $selectedItems = session(self::CART_ITEMS_SESSION_KEY, []);
        $selectedItems = array_filter($selectedItems, function ($item) use ($id) {
            return $item['id'] !== $id;
        });

        session([self::CART_ITEMS_SESSION_KEY => array_values($selectedItems)]);
    }

    private function applyDiscounts(CartDto $selectedItems): Collection
    {
        return app(QuantityDiscount::class)->apply($selectedItems);
    }

    private function calculateCartTotal(CartDto $cartDto): int
    {
        return $cartDto->items->sum('price') - $cartDto->discounts->sum('value');
    }

    private function getCartItems(): Collection
    {
        return collect(session(self::CART_ITEMS_SESSION_KEY, []))->map(function ($cartItem) {
            $item = Item::with(['prices','attributeValues.attribute'])->find($cartItem['itemId']);

            if (!$item) {
                return null;
            }

            $fromDate = Carbon::createFromFormat('Y-m-d H:i', $cartItem['fromDate']);
            $toDate = Carbon::createFromFormat('Y-m-d H:i', $cartItem['toDate']);

            $price = $this->itemRepository->calculatePriceForItem($item, $fromDate, $toDate);

            return new CartItemDto([
                'id' => $cartItem['id'],
                'item' => $item,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'price' => $price,
            ]);
        });
    }
}
