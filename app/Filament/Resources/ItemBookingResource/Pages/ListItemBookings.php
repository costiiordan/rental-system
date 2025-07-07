<?php

namespace App\Filament\Resources\ItemBookingResource\Pages;

use App\Filament\Resources\ItemBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemBookings extends ListRecords
{
    protected static string $resource = ItemBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
