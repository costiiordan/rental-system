<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages\CreateAttribute;
use App\Filament\Resources\AttributeResource\Pages\EditAttribute;
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
            ->columns(3)
            ->schema([
                TextInput::make('name.ro')
                    ->label('Nume (RO)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name.en')
                    ->label('Nume (EN)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('reference')
                    ->maxLength(255)
                    ->name('Referinta'),
                Repeater::make('values')
                    ->relationship('values')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('value.ro')
                            ->required()
                            ->maxLength(255)
                            ->label('Valoare (RO)'),
                        TextInput::make('value.en')
                            ->required()
                            ->maxLength(255)
                            ->label('Valoare (EN)'),
                        TextInput::make('reference')
                            ->maxLength(255)
                            ->name('Referinta'),

                    ])
                    ->label('Valori atribut')
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

    public static function getPages(): array
    {
        return [
            'index' => ListAttributes::route('/'),
            'create' => CreateAttribute::route('/create'),
            'edit' => EditAttribute::route('/{record}/edit'),
        ];
    }
}
