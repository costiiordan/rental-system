@use(App\Models\Constants\PaymentMethods)
@use(Illuminate\Support\Carbon)
<x-mail::message>
# Rezervare nouă

Numărul rezervării este <b>{{$order->id}}</b>.

Client:
{{$order->name}}<br>
{{$order->email}}<br>
{{$order->phone}}<br>

Plata: {{ $order->payment_method === PaymentMethods::CASH ? 'Cash' : '' }}{{ $order->payment_method === PaymentMethods::BANK_TRANSFER ? 'Transfer bancar' : '' }}{{ $order->payment_method === PaymentMethods::CARD ? 'Card online' : '' }}<br>
Total: {{$order->total}} RON<br>

Data ridicării: {{$pickupDate->format('d.m.Y H:i')}}<br>

<x-mail::table>
| @lang('Produs') | @lang('Pret') |
| :-------------- | :-----------: |
@foreach($order->orderItems as $orderItem)
@php
    $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderItem->itemBooking->from_date);
    $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderItem->itemBooking->to_date);
@endphp
@if($orderItem->item_id !== null)
| {{$orderItem->item->name}} - <x-duration :from="$fromDate" :to="$toDate" /> @lang('între') {{$fromDate->format('d.m H:i')}} - {{$toDate->format('m.d H:i')}} | {{$orderItem->price}} RON |
@else
| {{$orderItem->name}} | | -{{$orderItem->price}} RON |
@endif
@endforeach
</x-mail::table>

Echipa Rent a Bike Brașov
</x-mail::message>
