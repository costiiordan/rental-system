<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\Pages\ListAttributes;
use App\Models\Attribute;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Atribut';

    protected static ?string $pluralModelLabel = 'Atribute';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->name('Nume'),
                TextInput::make('reference')
                    ->maxLength(255)
                    ->name('Referinta'),
                Repeater::make('values')
                    ->relationship('values')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('value')
                            ->required()
                            ->maxLength(255)
                            ->label('Valoare'),
                        TextInput::make('reference')
                            ->maxLength(255)
                            ->name('Referinta'),

                    ])
                    ->label('Attribute Values')
                    ->defaultItems(1)
                    ->addActionLabel('Add Value'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->paginated(false);
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
            'index' => ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
