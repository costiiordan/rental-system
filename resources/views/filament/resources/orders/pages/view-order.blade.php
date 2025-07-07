<x-filament-panels::page>
    @php
        $order = $this->getRecord();
    @endphp

    <div class="space-y-6">
        {{-- Order Header --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex justify-between items-center">
                            <span>Informatii comanda</span>
                            {{ $this->editOrderAction() }}
                        </div>
                    </x-slot>

                    <div class="space-y-2">
                        <div>
                            <span class="font-medium text-gray-700">Status:</span>
                            <span class="text-gray-900">
                                <x-filament::badge
                                    class="inline-flex"
                                    :color="match($order->status) {
                                        \App\Models\Constants\OrderStatus::WAITING_PICKUP => 'warning',
                                        \App\Models\Constants\OrderStatus::PAYMENT_PENDING => 'warning',
                                        \App\Models\Constants\OrderStatus::PAYMENT_FAILED => 'danger',
                                        \App\Models\Constants\OrderStatus::CANCELED => 'danger',
                                        \App\Models\Constants\OrderStatus::COMPLETED => 'success',
                                    }"
                                >
                                    {{ match($order->status) {
                                        \App\Models\Constants\OrderStatus::WAITING_PICKUP => 'Asteptare ridicare',
                                        \App\Models\Constants\OrderStatus::PAYMENT_PENDING => 'Asteptare plata',
                                        \App\Models\Constants\OrderStatus::PAYMENT_FAILED => 'Plata esuata',
                                        \App\Models\Constants\OrderStatus::CANCELED => 'Anulata',
                                        \App\Models\Constants\OrderStatus::COMPLETED => 'Finalizata',
                                    } }}
                                </x-filament::badge>
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Metoda de plata:</span>
                            <span class="text-gray-900">
                                {{ match ($order->payment_method) {
                                    \App\Models\Constants\PaymentMethods::CASH => 'Numerar/Card la ridicare',
                                    \App\Models\Constants\PaymentMethods::BANK_TRANSFER => 'Transfer bancar',
                                    \App\Models\Constants\PaymentMethods::CARD => 'Card online',
                                } }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Data:</span>
                            <span class="text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Total:</span>
                            <span class="text-gray-900">{{ $order->total }} RON</span>
                        </div>
                    </div>
                </x-filament::section>
            </div>

            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex justify-between items-center">
                            <span>Informatii client</span>
                            {{ $this->editCustomerInfoAction() }}
                        </div>
                    </x-slot>

                    <div class="space-y-2">
                        <div>
                            <span class="font-medium text-gray-700">Name:</span>
                            <span class="text-gray-900">{{ $order->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Email:</span>
                            <span class="text-gray-900">{{ $order->email }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Phone:</span>
                            <span class="text-gray-900">{{ $order->phone }}</span>
                        </div>
                    </div>
                </x-filament::section>
            </div>

            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex justify-between items-center">
                            <span>Date facturare</span>
                            {{ $this->editCustomerBillingInfoAction() }}
                        </div>
                    </x-slot>

                    <div class="space-y-2">
                        <div>
                            <span class="font-medium text-gray-700">Nume:</span>
                            <span class="text-gray-900">{{ $order->billing_name }}</span>
                        </div>
                        @if($order->billing_vat_number)
                            <div>
                                <span class="font-medium text-gray-700">CUI:</span>
                                <span class="text-gray-900">{{ $order->billing_vat_number }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-700">Adresa:</span>
                            <div class="text-gray-900">
                                {{ $order->billing_address }}<br>
                                {{ $order->billing_city }}, {{ $order->billing_county }}<br>
                                {{ $order->billing_country }}
                            </div>
                        </div>
                    </div>
                </x-filament::section>
            </div>
        </div>

        {{ $this->table }}

        @if ($order->customer_note)
            <x-filament::section>
                <x-slot name="heading">
                    <span>Nota client</span>
                </x-slot>
                {{ $order->customer_note }}
            </x-filament::section>
        @endif

        <x-filament::section>
            <x-slot name="heading">
                <div class="flex justify-between items-center">
                    <span>Nota interna</span>
                    {{ $this->editInternalNoteAction() }}
                </div>
            </x-slot>
            {{ $order->internal_note }}
        </x-filament::section>

        {{-- Action Buttons (Optional) --}}
        <div class="flex space-x-3 gap-3">
            <x-filament::button
                color="gray"
                tag="a"
                :href="route('filament.admin.resources.orders.index')"
            >
                Inapoi la comenzi
            </x-filament::button>
            {{ $this->deleteOrderAction() }}
        </div>
    </div>
</x-filament-panels::page>
