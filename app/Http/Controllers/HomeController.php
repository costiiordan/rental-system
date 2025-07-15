<?php

namespace App\Http\Controllers;

use App\Repository\ItemRepository;
use App\Services\DateIntervalService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(
        ItemRepository      $itemRepository,
        DateIntervalService $dateIntervalRepository,
        ?string             $category = null
    ): View
    {
        $interval = $dateIntervalRepository->getInterval();

        $bikes = $itemRepository->getAvailableItems($interval->from ?? null, $interval->to ?? null, $category);

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
