<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages\CreateOrder;
use App\Filament\Resources\OrderResource\Pages\EditOrder;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use App\Models\Constants\OrderStatus;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.resources.orders.pages.view-order';
    protected static ?string $label = 'Comanda';
    protected static ?string $pluralLabel = 'Comenzi';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID Comanda')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nume Client')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        OrderStatus::WAITING_PICKUP => 'warning',
                        OrderStatus::PAYMENT_PENDING => 'warning',
                        OrderStatus::PAYMENT_FAILED => 'danger',
                        OrderStatus::COMPLETED => 'success',
                        OrderStatus::CANCELED => 'danger',
                    })
                ->formatStateUsing(fn ($state): string => match ($state) {
                    OrderStatus::WAITING_PICKUP => 'Asteptare ridicare',
                    OrderStatus::PAYMENT_PENDING => 'Asteptare plata',
                    OrderStatus::PAYMENT_FAILED => 'Plata esuata',
                    OrderStatus::CANCELED => 'Anulata',
                    OrderStatus::COMPLETED => 'Finalizata',
                }),
                TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Comenda in asteptare',
                        'done' => 'Comanda finalizata',
                        'canceled' => 'Comanda anulata',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === 'done') {
                            return $query->where('status', OrderStatus::COMPLETED);
                        }
                        elseif ($data['value'] === 'canceled') {
                            return $query->where('status', OrderStatus::CANCELED);
                        }

                        return $query->whereIn('status', [
                            OrderStatus::WAITING_PICKUP,
                            OrderStatus::PAYMENT_PENDING,
                            OrderStatus::PAYMENT_FAILED,
                        ]);
                    })
                    ->label('Status Comanda')
                    ->default('pending'),
            ])
            ->actions([
                ViewAction::make(),
            ])
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
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
            'view' => ViewOrder::route('/{record}'),
        ];
    }
}
