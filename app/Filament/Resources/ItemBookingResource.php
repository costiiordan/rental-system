<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemBookingResource\Pages\CreateItemBooking;
use App\Filament\Resources\ItemBookingResource\Pages\EditItemBooking;
use App\Filament\Resources\ItemBookingResource\Pages\ListItemBookings;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use App\Models\Constants\ItemStatus;
use App\Models\Item;
use App\Models\ItemBooking;
use App\Models\LockedDay;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class ItemBookingResource extends Resource
{
    protected static ?string $model = ItemBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Rezervare';

    protected static ?string $pluralModelLabel = 'Rezervari';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('item_id')
                    ->label('Produs')
                    ->options(self::getItemSelectOptions())
                    ->searchable()
                    ->selectablePlaceholder(false)
                    ->required()
                    ->preload(true)
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $fromDate = Carbon::parse($get('from_date'));
                            $toDate = Carbon::parse($get('to_date'));

                            if (!self::isItemAvailableInInterval($value, $fromDate, $toDate, $get('id'))) {
                                $fail('Produsul nu este disponibil in intervalul selectat.');
                            }
                        }
                    ]),
                TextInput::make('note')
                    ->label('Nota')
                    ->maxLength(255)
                    ->nullable(),
                DateTimePicker::make('from_date')
                    ->label('Data ridicare')->displayFormat('d.m.Y H:i')
                    ->native(false)
                    ->seconds(false)
                    ->minutesStep(60)
                    ->required()
                    ->beforeOrEqual('to_date')
                    ->default(Carbon::now()->hour(9)->minute(0)),
                DateTimePicker::make('to_date')
                    ->label('Data predare')->displayFormat('d.m.Y H:i')
                    ->native(false)
                    ->seconds(false)
                    ->minutesStep(60)
                    ->required()
                    ->afterOrEqual('from_date')
                    ->default(Carbon::now()->hour(18)->minute(0)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('from_date')->label('De la')->dateTime('d.m H:i')->sortable(),
                TextColumn::make('to_date')->label('Pana la')->dateTime('d.m H:i'),
                TextColumn::make('item.name')->label('Produs')->searchable(),
                TextColumn::make('item.sku')->label('Sku')->searchable(),
                TextColumn::make('orderItem.order.name')->label('Client')->searchable(),
                TextColumn::make('note')->label('Nota')->searchable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tip Rezervare')
                    ->options([
                        'future' => 'Rezervari viitoare',
                        'past' => 'Rezervari trecute',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === 'future') {
                            return $query->where('from_date', '>=', Carbon::today());
                        }
                        if ($data['value'] === 'past') {
                            return $query->where('from_date', '<', Carbon::today());
                        }

                        return $query;
                    })
                    ->default('future'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn ($record) => !$record->orderItem()->exists())
                    ->label('Sterge'),
                Action::make('view_order')
                    ->label('Vezi comanda')
                    ->visible(fn ($record) => $record->orderItem()->exists())
                    ->icon('heroicon-o-eye')
                    ->color('secondary')
                    ->url(fn ($record) => ViewOrder::getUrl(['record' => $record->orderItem->order->id])),
            ])
            ->defaultSort('from_date', 'asc')
            ->paginationPageOptions([20]);
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
            'index' => ListItemBookings::route('/'),
            'create' => CreateItemBooking::route('/create'),
            'edit' => EditItemBooking::route('/{record}/edit'),
        ];
    }

    private static function getItemSelectOptions()
    {
        return Item::query()->where('status', ItemStatus::ACTIVE)
            ->get(['id', 'name', 'sku'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name . ' sku: ' . $item->sku,
                ];
            })
            ->pluck('name', 'id');
    }

    private static function isItemAvailableInInterval(int $itemId, Carbon $fromDate, Carbon $toDate, ?int $bookingItemId = null): bool
    {
        $hasBookingsInInterval = ItemBooking::where('item_id', $itemId)
            ->where('id', '!=', $bookingItemId)
            ->where('from_date', '<', $toDate)
            ->where('to_date', '>', $fromDate)
            ->exists();

        $overlapsLockedLays = LockedDay::where('date', '=', $fromDate->startOfDay())
            ->orWhere('date', '=', $toDate->endOfDay())
            ->exists();

        return !$hasBookingsInInterval && !$overlapsLockedLays;
    }
}
