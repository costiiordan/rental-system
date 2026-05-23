<?php

namespace App\Http\Controllers;

use App\Models\Constants\AttributeReference;
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
        $bikes = $itemRepository->getAvailableItems(null, null, $category?->reference)
            ->sortBy(fn ($bike) => $bike->attributeValues
                ->firstWhere('attribute.reference', AttributeReference::CATEGORY)?->id ?? PHP_INT_MAX)
            ->values();

        return view('price-list', [
            'bikes' => $bikes,
            'category' => $category,
        ]);
    }
}
