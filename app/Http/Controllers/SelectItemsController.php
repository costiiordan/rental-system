<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemoveSelectedItemRequest;
use App\Http\Requests\SelectItemRequest;
use App\Repository\SelectedItemsRepository;
use Illuminate\Http\JsonResponse;

class SelectItemsController extends Controller
{
    public function addItem(SelectItemRequest $request, SelectedItemsRepository $selectedItemsRepository): JsonResponse
    {
        $validated = $request->validated();

        $selectedItemsRepository->addItem($validated);

        return response()->json();
    }

    public function getSelectedItems(SelectedItemsRepository $selectedItemsRepository): JsonResponse
    {
        $selectedItems = $selectedItemsRepository->getSelectedItems();

        return response()->json([
            'selectedItems' => $selectedItems->toArray(),
        ]);
    }

    public function removeItem(RemoveSelectedItemRequest $request, SelectedItemsRepository $selectedItemsRepository): JsonResponse
    {
        $selectedItemsRepository->removeItem($request->post('id'));

        return response()->json();
    }
}
