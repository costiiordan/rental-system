<?php

namespace App\Http\Controllers;

use App\Repository\ItemRepository;
use Illuminate\View\View;

class PriceListController extends Controller
{
    public function __invoke(ItemRepository $itemRepository): View
    {
        $items = $itemRepository->getAllItemsForPriceList();

        $columns = [];
        foreach ($items as $item) {
            foreach ($item->prices as $price) {
                $key = $price->duration_unit.'_'.$price->duration;
                $columns[$key] = [
                    'duration_unit' => $price->duration_unit,
                    'duration' => (int) $price->duration,
                ];
            }
        }

        $priceColumns = array_values($columns);
        usort($priceColumns, function (array $a, array $b): int {
            return strcmp($b['duration_unit'], $a['duration_unit'])
                ?: $a['duration'] <=> $b['duration'];
        });

        return view('price-list', [
            'items' => $items,
            'priceColumns' => $priceColumns,
        ]);
    }
}
