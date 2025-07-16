<?php

namespace App\Http\Controllers;

use App\Repository\ItemRepository;
use App\Services\CategoryFilterService;
use App\Services\DateIntervalService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(
        ItemRepository $itemRepository,
        DateIntervalService $dateIntervalRepository,
        CategoryFilterService $categoryFilterService,
    ): View
    {
        $interval = $dateIntervalRepository->getInterval();
        $category = $categoryFilterService->getCategory();

        $bikes = $itemRepository->getAvailableItems(
            $interval->from ?? null,
            $interval->to ?? null,
                $category?->reference,
        );

        $prices = [];

        if ($interval) {
            $prices = $itemRepository->getPricesForItems($bikes, $interval->from, $interval->to);
        }

        return view('home', [
            'bikes' => $bikes,
            'interval' => $interval,
            'prices' => $prices,
            'category' => $category,
        ]);

    }
}
