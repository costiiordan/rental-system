<?php

namespace App\Filament\Resources\LockedDayResource\Pages;

use App\Filament\Resources\LockedDayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLockedDays extends ListRecords
{
    protected static string $resource = LockedDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
