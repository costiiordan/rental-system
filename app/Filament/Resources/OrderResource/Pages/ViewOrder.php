<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Constants\ItemStatus;
use App\Models\Constants\OrderStatus;
use App\Models\Constants\PaymentMethods;
use App\Models\Item;
use App\Models\ItemBooking;
use App\Models\LockedDay;
use App\Models\OrderItem;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class ViewOrder extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = OrderResource::class;
    protected static string $view = 'filament.resources.orders.pages.view-order';

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderItem::query()->with(['item', 'itemBooking'])->where('order_id', $this->record->id)->orderBy('item_id'))
            ->columns([
                TextColumn::make('name')->label('Produs')->formatStateUsing(function ($state, $column) {
                    if ($column->getRecord()->item) {
                        return $column->getRecord()->item->name;
                    }

                    return $state;
                }),
                TextColumn::make('item.sku')->label('Sku'),
                TextColumn::make('itemBooking.from_date')->label('De la')->dateTime('d.m H:i'),
                TextColumn::make('itemBooking.to_date')->label('De la')->dateTime('d.m H:i'),
                TextColumn::make('price')->label('Pret')->formatStateUsing(function ($state, $column) {
                    if ($column->getRecord()->item) {
                        return $state.' RON';
                    }

                    return '-'.$state.' RON';
                }),
            ])
            ->actions([
                TableAction::make('editOrderItem')
                    ->hiddenLabel()
                    ->icon('heroicon-o-pencil-square')
                    ->button()
                    ->size(ActionSize::Small)
                    ->modalHeading(fn (OrderItem $record): string => $record->item_id ? 'Editeaza rezervarea' : 'Editeaza discount')
                    ->modalSubmitActionLabel('Salveaza')
                    ->fillForm(fn (OrderItem $record) => $this->fillEditOrderItemForm($record))
                    ->form(fn (OrderItem $record) => $this->createEditOrderItemForm($record))
                    ->action(fn (array $data) => $this->editOrderItemActionCallback($data)),
                TableAction::make('removeOrderItem')
                    ->hiddenLabel()
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->size(ActionSize::Small)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (OrderItem $record) {
                        if ($record->item_booking_id) {
                            $itemBooking = ItemBooking::query()->where('id', $record->item_booking_id)->first();

                            if ($itemBooking) {
                                $itemBooking->delete();
                            }
                        }

                        $orderId = $record->order_id;

                        $record->delete();

                        $this->updateOrderTotal($orderId);

                        $this->sendOrderSavedNotification();
                    })
            ])
            ->paginated(false);
    }

    public function editOrderAction(): Action
    {
        return Action::make('editOrder')
            ->icon('heroicon-o-pencil-square')
            ->hiddenLabel()
            ->button()
            ->size(ActionSize::Small)
            ->modalHeading('Editeaza comanda')
            ->modalSubmitActionLabel('Salveaza')
            ->fillForm([
                'status' => $this->record->status,
            ])
            ->form([
                Select::make('status')
                    ->label('Status nou')
                    ->options([
                        OrderStatus::WAITING_PICKUP => 'Asteptare ridicare',
                        OrderStatus::PAYMENT_PENDING => 'Asteptare plata',
                        OrderStatus::PAYMENT_FAILED => 'Plata esuata',
                        OrderStatus::COMPLETED => 'Finalizata',
                        OrderStatus::CANCELED => 'Anulata',
                    ])
                    ->required()
                    ->selectablePlaceholder(false),
                Select::make('payment_method')
                    ->label('Metoda plata')
                    ->options([
                        PaymentMethods::CASH => 'Cash/Card la ridiare',
                        PaymentMethods::CARD => 'Card online',
                        PaymentMethods::BANK_TRANSFER => 'Transfer bancar',
                    ])
                    ->default($this->record->payment_method)
                    ->required()
                    ->selectablePlaceholder(false),
            ])
            ->action(function (array $data) {
                $this->record->status = $data['status'];
                $this->record->payment_method = $data['payment_method'];
                $this->record->save();

                $this->sendOrderSavedNotification();
            });
    }

    public function deleteOrderAction(): Action
    {
        return Action::make('deleteOrder')
            ->label('Sterge comanda')
            ->button()
            ->size(ActionSize::Small)
            ->color('danger')
            ->requiresConfirmation()
            ->action(function () {
                $this->record->delete();

                Notification::make()
                    ->title('Comanda a fost stearsa')
                    ->success()
                    ->send();

                return redirect()->route('filament.resources.orders.index');
            });
    }

    public function editInternalNoteAction(): Action
    {
        return Action::make('editInternalNote')
            ->icon('heroicon-o-pencil-square')
            ->hiddenLabel()
            ->button()
            ->size(ActionSize::Small)
            ->modalHeading('Nota interna')
            ->form([
                Textarea::make('internal_note')
                    ->hiddenLabel(),
            ])
            ->fillForm(['internal_note' => $this->record->internal_note])
            ->modalSubmitActionLabel('Salveaza')
            ->action(function (array $data) {
                $this->record->internal_note = $data['internal_note'];
                $this->record->save();

                $this->sendOrderSavedNotification();
            });
    }

    public function editCustomerInfoAction(): Action
    {
        return Action::make('editCustomerInfo')
            ->icon('heroicon-o-pencil-square')
            ->hiddenLabel()
            ->button()
            ->size(ActionSize::Small)
            ->modalHeading('Editeaza informatii client')
            ->form([
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->required(),
            ])
            ->fillForm([
                'name' => $this->record->name,
                'email' => $this->record->email,
                'phone' => $this->record->phone,
            ])
            ->modalSubmitActionLabel('Salveaza')
            ->action(function (array $data) {
                $this->record->name = $data['name'];
                $this->record->email = $data['email'];
                $this->record->phone = $data['phone'];
                $this->record->save();

                $this->sendOrderSavedNotification();
            });
    }

    public function editCustomerBillingInfoAction(): Action
    {
        return Action::make('editCustomerBillingInfo')
            ->icon('heroicon-o-pencil-square')
            ->hiddenLabel()
            ->button()
            ->size(ActionSize::Small)
            ->modalHeading('Editeaza date facturare client')
            ->form([
                TextInput::make('billing_name')
                    ->label('Nume')
                    ->required(),
                TextInput::make('billing_vat_number')
                    ->label('CUI / CNP')
                    ->required(),
                TextInput::make('billing_address')
                    ->label('Adresa')
                    ->required(),
                TextInput::make('billing_city')
                    ->label('Localitate')
                    ->required(),
                TextInput::make('billing_county')
                    ->label('Judet')
                    ->required(),
                TextInput::make('billing_country')
                    ->label('Tara')
                    ->required(),
            ])
            ->fillForm([
                'billing_name' => $this->record->billing_name,
                'billing_vat_number' => $this->record->billing_vat_number,
                'billing_address' => $this->record->billing_address,
                'billing_city' => $this->record->billing_city,
                'billing_county' => $this->record->billing_county,
                'billing_country' => $this->record->billing_country,
            ])
            ->modalSubmitActionLabel('Salveaza')
            ->action(function (array $data) {
                $this->record->billing_name = $data['billing_name'];
                $this->record->billing_vat_number = $data['billing_vat_number'];
                $this->record->billing_address = $data['billing_address'];
                $this->record->billing_city = $data['billing_city'];
                $this->record->billing_county = $data['billing_county'];
                $this->record->billing_country = $data['billing_country'];
                $this->record->save();

                $this->sendOrderSavedNotification();
            });
    }

    public function addOrderItemAction(): Action
    {
        return Action::make('addOrderItem')
            ->icon('heroicon-o-plus')
            ->label('Adauga produs')
            ->button()
            ->size(ActionSize::Small)
            ->modalHeading('Adauga produs la comanda')
            ->modalSubmitActionLabel('Salveaza')
            ->form([
                Select::make('item_id')
                    ->label('Produs')
                    ->options($this->getItemSelectOptions())
                    ->searchable()
                    ->selectablePlaceholder(false)
                    ->required()
                    ->preload(true)
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $fromDate = Carbon::parse($get('from_date'));
                            $toDate = Carbon::parse($get('to_date'));

                            if (!$this->isItemAvailableInInterval($value, $fromDate, $toDate)) {
                                $fail('Produsul nu este disponibil in intervalul selectat.');
                            }
                        }
                    ]),
                TextInput::make('price')
                    ->label('Pret')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(100000),
                Hidden::make('order_id')->default($this->record->id),
            ])
            ->action(function (array $data) {
                $item = Item::query()->findOrFail($data['item_id']);

                $fromDate = Carbon::parse($data['from_date']);
                $toDate = Carbon::parse($data['to_date']);

                $itemBooking = new ItemBooking([
                    'item_id' => $data['item_id'],
                    'from_date' => $fromDate->format('Y-m-d H:i:s'),
                    'to_date' => $toDate->format('Y-m-d H:i:s'),
                ]);
                $itemBooking->save();

                $orderItem = new OrderItem([
                    'order_id' => $data['order_id'],
                    'item_id' => $data['item_id'],
                    'item_booking_id' => $itemBooking->id,
                    'name' => "Inchieriere ".$item->name . ' (' . $fromDate->format('d.m.Y H:i') . ' - ' . $toDate->format('d.m.Y H:i') . ')',
                    'price' => $data['price'],
                ]);
                $orderItem->save();

                $this->updateOrderTotal($data['order_id']);

                $this->sendOrderSavedNotification();
            });
    }

    public function addDiscountAction(): Action
    {
        return Action::make('addDiscount')
            ->icon('heroicon-o-plus')
            ->label('Adauga discount')
            ->button()
            ->size(ActionSize::Small)
            ->modalHeading('Adauga discount')
            ->modalSubmitActionLabel('Salveaza')
            ->form([
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                TextInput::make('price')
                    ->label('Valoare')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(100000),
                Hidden::make('order_id')->default($this->record->id),
            ])
            ->action(function (array $data) {
                $orderItem = new OrderItem([
                    'order_id' => $data['order_id'],
                    'name' => $data['name'],
                    'price' => $data['price'],
                ]);
                $orderItem->save();

                $this->updateOrderTotal($data['order_id']);

                $this->sendOrderSavedNotification();
            });
    }

    private function editOrderItemActionCallback(array $data): void
    {
        if ($data['order_item_type'] === 'discount') {
            $this->editOrderDiscountActionCallback($data);

            return;
        }

        $orderItem = OrderItem::query()->where('id', $data['order_item_id'])->first();
        $itemBooking = ItemBooking::query()->where('id', $data['item_booking_id'])->first();
        $item = Item::query()->where('id', $data['item_id'])->first();
        $fromDate = Carbon::parse($data['from_date']);
        $toDate = Carbon::parse($data['to_date']);

        if (!$orderItem) {
            Notification::make()
                ->title('Produsul comandat nu a fost gasita')
                ->danger()
                ->send();
            return;
        }

        if (!$itemBooking) {
            Notification::make()
                ->title('Rezervarea nu a fost gasita')
                ->danger()
                ->send();
            return;
        }

        if ($orderItem->item_booking_id !== $itemBooking->id) {
            Notification::make()
                ->title('Rezervarea nu corespunde cu produsul selectat')
                ->danger()
                ->send();
            return;
        }

        if (!$item) {
            Notification::make()
                ->title('Produsul nu a fost gasit')
                ->danger()
                ->send();
            return;
        }

        if ($item->status !== ItemStatus::ACTIVE) {
            Notification::make()
                ->title('Produsul nu este activ')
                ->danger()
                ->send();
            return;
        }

        $itemBooking->from_date = $fromDate->format('Y-m-d H:i:s');
        $itemBooking->to_date = $toDate->format('Y-m-d H:i:s');
        $itemBooking->item_id = $data['item_id'];
        $itemBooking->save();

        $orderItem->item_id = $data['item_id'];
        $orderItem->price = $data['price'];
        $orderItem->name = "Inchieriere ".$item->name . ' (' . $fromDate->format('d.m.Y H:i') . ' - ' . $toDate->format('d.m.Y H:i') . ')';
        $orderItem->save();

        $this->updateOrderTotal($orderItem->order_id);

        $this->sendOrderSavedNotification();
    }

    private function updateOrderTotal(int $orderId): void
    {
        $items = OrderItem::query()->where('order_id', $orderId)->get(['price', 'item_id']);

        $total = $items->reduce(function ($total, $item) {
            if ($item->item_id) {
                return $total + $item->price;
            }

            return $total - $item->price;
        }, 0);

        $this->record->total = $total;
        $this->record->save();
    }

    private function createEditOrderItemForm(OrderItem $orderItem): array
    {
        if (!$orderItem->item_id) {
            return [
                TextInput::make('name')
                    ->label('Nume')
                    ->required(),
                TextInput::make('price')
                    ->label('Valoare')
                    ->required(),
                Hidden::make('order_item_id'),
                Hidden::make('order_item_type'),
            ];
        }

        return [
            DateTimePicker::make('from_date')
                ->label('Data ridicare')
                ->displayFormat('d.m.Y H:i')
                ->native(false)
                ->seconds(false)
                ->minutesStep(60)
                ->required()
                ->beforeOrEqual('to_date'),
            DateTimePicker::make('to_date')
                ->label('Data predare')
                ->displayFormat('d.m.Y H:i')
                ->seconds(false)
                ->minutesStep(60)
                ->native(false)
                ->required()
                ->afterOrEqual('from_date'),
            Select::make('item_id')
                ->label('Produs')
                ->options($this->getItemSelectOptions())
                ->required()
                ->rules([
                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                        $fromDate = Carbon::parse($get('from_date'));
                        $toDate = Carbon::parse($get('to_date'));
                        $itemBookingId = $get('item_booking_id') ?? null;

                        if (!$this->isItemAvailableInInterval($value, $fromDate, $toDate, $itemBookingId)) {
                            $fail('Produsul nu este disponibil in intervalul selectat.');
                        }
                    }
                ])
                ->searchable()
                ->selectablePlaceholder(false),
            TextInput::make('price')
                ->label('Pret')
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(100000),
            Hidden::make('item_booking_id'),
            Hidden::make('order_item_id'),
            Hidden::make('order_item_type'),
        ];
    }

    private function fillEditOrderItemForm(OrderItem $orderItem): array
    {
        if (!$orderItem->item_id) {
            return [
                'order_item_id' => $orderItem->id,
                'name' => $orderItem->name,
                'price' => $orderItem->price,
                'order_item_type' => 'discount',
            ];
        }

        return [
            'from_date' => $orderItem->itemBooking->from_date,
            'to_date' => $orderItem->itemBooking->to_date,
            'item_id' => $orderItem->item_id,
            'price' => $orderItem->price,
            'item_booking_id' => $orderItem->itemBooking->id,
            'order_item_id' => $orderItem->id,
            'order_item_type' => 'item_booking',
        ];
    }

    private function editOrderDiscountActionCallback(array $data): void
    {
        $orderItem = OrderItem::query()->where('id', $data['order_item_id'])->first();

        $orderItem->name = $data['name'];
        $orderItem->price = $data['price'];
        $orderItem->save();

        $this->updateOrderTotal($orderItem->order_id);
        $this->sendOrderSavedNotification();
    }

    private function sendOrderSavedNotification(): void
    {
        Notification::make()
            ->title('Comanda a fost salvata')
            ->success()
            ->send();
    }

    private function isItemAvailableInInterval(int $itemId, Carbon $fromDate, Carbon $toDate, int $bookingItemId = null): bool
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

    private function getItemSelectOptions()
    {
        return Item::query()->where('status', ItemStatus::ACTIVE)->get(['id', 'name', 'sku'])->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name . ' sku: ' . $item->sku,
            ];
        })->pluck('name', 'id');
    }
}
