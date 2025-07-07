<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemBookingResource\Pages;
use App\Models\ItemBooking;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItemBookingResource extends Resource
{
    protected static ?string $model = ItemBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Rezervare';

    protected static ?string $pluralModelLabel = 'Rezervari';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from_date')->label('De la')->dateTime('d.m H:i'),
                Tables\Columns\TextColumn::make('to_date')->label('Pana la')->dateTime('d.m H:i'),
                Tables\Columns\TextColumn::make('item.name')->label('Produs'),
                Tables\Columns\TextColumn::make('item.sku')->label('Sku'),
                Tables\Columns\TextColumn::make('orderItem.order.name')->label('Client'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItemBookings::route('/'),
            'create' => Pages\CreateItemBooking::route('/create'),
            'edit' => Pages\EditItemBooking::route('/{record}/edit'),
        ];
    }
}
