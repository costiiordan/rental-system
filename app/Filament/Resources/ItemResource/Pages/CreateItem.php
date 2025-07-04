<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Resources\Pages\CreateRecord;
use JetBrains\PhpStorm\NoReturn;

class CreateItem extends CreateRecord
{
    protected static string $resource = ItemResource::class;

    #[NoReturn] protected function afterCreate(): void
    {
        $data = $this->form->getState();

        $selectedValueIds = [];

        foreach ($data['attribute'] as $valueId) {
            if (is_string($valueId)) {
                $selectedValueIds[] = $valueId;
            }
        }

        /** @var \App\Models\Item $itemModel */
        $itemModel = $this->getRecord();

        $itemModel->attributeValues()->sync($selectedValueIds);
    }
}
