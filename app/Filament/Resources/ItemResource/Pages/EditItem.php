<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JetBrains\PhpStorm\NoReturn;

class EditItem extends EditRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    #[NoReturn] protected function afterSave(): void
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
