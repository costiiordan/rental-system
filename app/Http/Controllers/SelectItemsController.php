<?php

namespace App\Http\Controllers;

use App\Http\Requests\SelectItemRequest;
use App\Repository\SelectedItemsRepository;
use Illuminate\Http\JsonResponse;

class SelectItemsController extends Controller
{
    public function addItem(SelectItemRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $selectedItems = session('selectedItems', []);

        $selectedItems[] = [
            'itemId' => $validated['itemId'],
            'fromDateTime' => $validated['fromDateTime'],
            'toDateTime' => $validated['toDateTime'],
        ];

        session(['selectedItems' => $selectedItems]);

        return response()->json();
    }

    public function getSelectedItems(SelectedItemsRepository $selectedItemsRepository): JsonResponse
    {
        $selectedItems = $selectedItemsRepository->getSelectedItems();

        return response()->json([
            'selectedItems' => $selectedItems->toArray(),
        ]);
    }
}
