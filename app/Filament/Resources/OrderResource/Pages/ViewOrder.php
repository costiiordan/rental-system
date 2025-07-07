<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Constants\OrderStatus;
use App\Models\Constants\PaymentMethods;
use App\Models\OrderItem;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ViewOrder extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = OrderResource::class;
    protected static string $view = 'filament.resources.orders.pages.view-order';

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderItem::query()->with(['item', 'itemBooking'])->where('order_id', $this->record->id))
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
            ->paginated(false);
    }

    public function editOrderAction(): Action
    {
        return Action::make('editOrder')
            ->icon('heroicon-o-pencil-square')
            ->hiddenLabel()
            ->button()
            ->modalHeading('Editeaza comanda')
            ->modalSubmitActionLabel('Salveaza')
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
                    ->default($this->record->status)
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

                Notification::make()
                    ->title('Comanda a fost actualizata')
                    ->success()
                    ->send();
            });
    }

    public function deleteOrderAction(): Action
    {
        return Action::make('deleteOrder')
            ->label('Sterge comanda')
            ->button()
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
            ->modalHeading('Nota interna')
            ->form([
                Textarea::make('internal_note')
                    ->hiddenLabel()
                    ->default($this->record->internal_note),
            ])
            ->modalSubmitActionLabel('Salveaza')
            ->action(function (array $data) {
                $this->record->internal_note = $data['internal_note'];
                $this->record->save();

                Notification::make()
                    ->title('Comanda a fost actualizata')
                    ->success()
                    ->send();
            });
    }

    public function editCustomerInfoAction(): Action
    {
        return Action::make('editCustomerInfo')
            ->icon('heroicon-o-pencil-square')
            ->hiddenLabel()
            ->button()
            ->modalHeading('Editeaza informatii client')
            ->form([
                TextInput::make('name')
                    ->label('Nume')
                    ->default($this->record->name)
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->default($this->record->email)
                    ->required()
                    ->email(),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->default($this->record->phone)
                    ->required(),
            ])
            ->modalSubmitActionLabel('Salveaza')
            ->action(function (array $data) {
                $this->record->name = $data['name'];
                $this->record->email = $data['email'];
                $this->record->phone = $data['phone'];
                $this->record->save();

                Notification::make()
                    ->title('Comanda a fost actualizata')
                    ->success()
                    ->send();
            });
    }

    public function editCustomerBillingInfoAction(): Action
    {
        return Action::make('editCustomerBillingInfo')
            ->icon('heroicon-o-pencil-square')
            ->hiddenLabel()
            ->button()
            ->modalHeading('Editeaza date facturare client')
            ->form([
                TextInput::make('billing_name')
                    ->label('Nume')
                    ->default($this->record->billing_name)
                    ->required(),
                TextInput::make('billing_vat_number')
                    ->label('CUI / CNP')
                    ->default($this->record->billing_vat_number)
                    ->required(),
                TextInput::make('billing_address')
                    ->label('Adresa')
                    ->default($this->record->billing_address)
                    ->required(),
                TextInput::make('billing_city')
                    ->label('Localitate')
                    ->default($this->record->billing_city)
                    ->required(),
                TextInput::make('billing_county')
                    ->label('Judet')
                    ->default($this->record->billing_county)
                    ->required(),
                TextInput::make('billing_country')
                    ->label('Tara')
                    ->default($this->record->billing_country)
                    ->required(),
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

                Notification::make()
                    ->title('Comanda a fost actualizata')
                    ->success()
                    ->send();
            });
    }
}
