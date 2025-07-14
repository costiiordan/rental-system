<?php

namespace App\Http\Controllers;

use App\Dto\IntervalDto;
use App\Repository\ItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function __invoke(ItemRepository $itemRepository, Request $request, ?string $category = null)
    {
        $interval = $this->getInterval($request);

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

    private function getInterval(Request $request): ?IntervalDto
    {
        $from = $this->getDateTime($request->get('from_date'), $request->get('from_time'));
        $to = $this->getDateTime($request->get('to_date'), $request->get('to_time'));

        if (!$from || !$to) {
            return null;
        }

        $fromCarbon = Carbon::createFromFormat('Y-m-d H:i', $from);
        $toCarbon = Carbon::createFromFormat('Y-m-d H:i', $to);

        if ($fromCarbon->greaterThanOrEqualTo($toCarbon)) {
            $temp = $fromCarbon;
            $fromCarbon = $toCarbon;
            $toCarbon = $temp;
        }

        return new IntervalDto([
            'from' => $fromCarbon,
            'to' => $toCarbon,
        ]);
    }

    private function getDateTime(?string $date, ?string $time): ?string
    {
        if (!$date || !$time) {
            return null;
        }

        return $date . ' ' . $time;
    }
}
