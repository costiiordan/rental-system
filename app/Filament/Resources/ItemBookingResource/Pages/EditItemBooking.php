<?php

namespace App\Filament\Resources\ItemBookingResource\Pages;

use App\Filament\Resources\ItemBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemBooking extends EditRecord
{
    protected static string $resource = ItemBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
