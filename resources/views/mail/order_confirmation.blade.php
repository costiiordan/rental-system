@use(App\Models\Constants\PaymentMethods)
@use(Illuminate\Support\Carbon)
<x-mail::message>
# @lang('Rezervare confirmată!')

@lang('Numărul rezervării este <b>:orderId</b>.', ['orderId' => $order->id])<br>

@if($order->payment_method === PaymentMethods::BANK_TRANSFER)
@lang('Te rugăm să achiți suma de <b>:amount RON</b> în contul nostru bancar:', ['amount' => $order->total])<br>
<x-mail::panel>
@lang('Iban'): <strong>RO92BACX0000000767636000</strong><br>
@lang('Beneficiar'): <strong>Burtan Ciprian Iulius Intreprindere Individuala</strong><br>
@lang('Banca'): <strong>Unicredit Bank S.A.</strong><br>
@lang('Detalii plată'): <strong>@lang('Plata rezervare nr :orderId', ['orderId' => $order->id])</strong><br>
</x-mail::panel>
@endif

@if($order->payment_method === PaymentMethods::CASH)
@lang('Suma de plată este <b>:amount RON</b> și va fi achitată în momentul ridicării produselor.', ['amount' => $order->total])<br>
@endif

@lang('Vă asteptăm în data de <b>:date</b> la centrul nostru pentru a ridica produsele rezervate.', ['date' => $pickupDate->format('d.m.Y H:i')])<br>

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

@lang('Echipa Rent a Bike Brașov')
</x-mail::message>
