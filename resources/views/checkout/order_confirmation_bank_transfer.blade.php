@extends('layout.default')

@section('content')
    <div class="order-confirmation-container">
        <span class="material-symbols-outlined order-confirmation-icon">check_circle</span>
        <p class="order-confirmation-text">
            @lang('Rezervarea a fost salvată cu succes.')<br>
            @lang('Te rugăm să achiți suma de <b>:amount RON</b> în contul nostru bancar:', ['amount' => $order->total])<br>
            <span class="order-confirmation-bank-details">
                @lang('Iban'): <strong>RO92BACX0000000767636000</strong><br>
                @lang('Beneficiar'): <strong>Burtan Ciprian Iulius Intreprindere Individuala</strong><br>
                @lang('Banca'): <strong>Unicredit Bank S.A.</strong><br>
                @lang('Detalii plată'): <strong>@lang('Plata rezervare nr :orderId', ['orderId' => $order->id])</strong>
            </span><br>
            @lang('Te așteptăm în data de <b>:date</b> pentru a ridica produsele.', ['date' => $date->format('d.m.Y H:i')])
        </p>
    </div>

    <div class="order-confirmation-back-to-homepage">
        <a href="{{route('home')}}" >@lang('Înapoi pe prima pagină')</a>
    </div>
@endsection
