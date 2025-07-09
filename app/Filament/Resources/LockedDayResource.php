<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LockedDayResource\Pages\CreateLockedDay;
use App\Filament\Resources\LockedDayResource\Pages\ListLockedDays;
use App\Models\LockedDay;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LockedDayResource extends Resource
{
    protected static ?string $model = LockedDay::class;
    protected static ?int $navigationSort = 5;
    protected static ?string $label = 'Zi blocata';
    protected static ?string $pluralLabel = 'Zile blocate';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->displayFormat('d.m.Y')
                    ->required()
                    ->native(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label('Data')->sortable()
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->defaultSort('date', 'desc')
            ->paginationPageOptions([30]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLockedDays::route('/'),
            'create' => CreateLockedDay::route('/create'),
        ];
    }
}
