<?php

namespace App\Http\Controllers;

use App\Repository\ItemRepository;
use App\Services\CategoryFilterService;
use Illuminate\View\View;

class PriceListController extends Controller
{
    public function __invoke(
        ItemRepository $itemRepository,
        CategoryFilterService $categoryFilterService,
    ): View {
        $category = $categoryFilterService->getCategory();
        $bikes = $itemRepository->getAvailableItems(null, null, $category?->reference);

        return view('price-list', [
            'bikes' => $bikes,
            'category' => $category,
        ]);
    }
}
