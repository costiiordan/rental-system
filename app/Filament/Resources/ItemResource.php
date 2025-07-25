<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages\CreateItem;
use App\Filament\Resources\ItemResource\Pages\EditItem;
use App\Filament\Resources\ItemResource\Pages\ListItems;
use App\Models\Attribute;
use App\Models\Constants\ItemStatus;
use App\Models\Item;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Produs';

    protected static ?string $pluralModelLabel = 'Produse';

    public static function form(Form $form): Form
    {
        $form
            ->schema([
                TextInput::make('name.ro')
                    ->label('Nume (RO)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name.en')
                    ->label('Nume (EN)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sku')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('description.ro')
                    ->label('Descriere (RO)')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                Textarea::make('description.en')
                    ->label('Descriere (EN)')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                Section::make('Atribute')
                    ->columns(3)
                    ->schema(function () use ($form) {
                        $attributes = Attribute::with('values')->get();
                        $selectedValues = $form->getRecord()?->attributeValues()->pluck('item_attribute_value.attribute_value_id')->toArray();

                        return $attributes->map(function ($attribute) use ($selectedValues) {
                            $options = $attribute->values->pluck('value', 'id')->toArray();
                            $selected = array_values(array_intersect(array_keys($options), $selectedValues ?? []));

                            return Radio::make("attribute.{$attribute->id}")
                                ->label($attribute->name)
                                ->options($options)
                                ->formatStateUsing(function() use ($selected) {
                                    if (empty($selected)) {
                                        return null;
                                    }

                                    return (string)$selected[0];
                                });
                        })->toArray();
                    }),

                Repeater::make('prices')
                    ->label('Preturi')
                    ->columns(3)
                    ->columnSpan(2)
                    ->relationship('prices')
                    ->schema([
                        TextInput::make('price')
                            ->label('Pret')
                            ->required()
                            ->integer()
                            ->maxLength(10),
                        TextInput::make('duration')
                            ->label('Durata')
                            ->required()
                            ->integer()
                            ->maxLength(10),
                        Select::make('duration_unit')
                            ->label('Unitate')
                            ->required()
                            ->options([
                                'hour' => 'Ora',
                                'day' => 'Zi',
                            ])
                            ->default('day')
                            ->selectablePlaceholder(false),
                    ])
                    ->addActionLabel('Adauga pret')
                    ->defaultItems(1),

                FileUpload::make('image_path')
                    ->label('Imagine (format 4:3, recomandat 1024x768px)')
                    ->required()
                    ->disk('public')
                    ->directory('items')
                    ->image()
                    ->imageEditor(),

                Select::make('status')
                    ->label('Stare')
                    ->options([
                        ItemStatus::ACTIVE => 'Activ',
                        ItemStatus::INACTIVE => 'Inactiv',
                        ItemStatus::HIDDEN => 'Ascuns',
                    ])
                    ->default(ItemStatus::ACTIVE)
                    ->required()
                    ->selectablePlaceholder(false),

                TextInput::make('order')
                    ->numeric()
                    ->name('Ordine (0-primul, 99-ultimul)'),
            ]);

        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sku'),
                TextColumn::make('name'),
                TextColumn::make('order')
                    ->label('Ordine'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->paginated(false)
            ->defaultSort('order', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            'edit' => EditItem::route('/{record}/edit'),
        ];
    }
}
