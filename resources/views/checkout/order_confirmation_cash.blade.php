@extends('layout.default')

@section('content')
    <div class="order-confirmation-container">
        <span class="material-symbols-outlined order-confirmation-icon">check_circle</span>
        <p class="order-confirmation-text">
            @lang('Rezervarea a fost salvată cu succes.')<br>
            @lang('Te așteptăm în data de <b>:date</b> la centrul nostru.', ['date' => $pickupDate->format('d.m.Y H:i')])<br>
            @lang('Suma de plată este <b>:amount RON</b> și va fi achitată în momentul ridicării produselor.', ['amount' => $order->total])
        </p>
    </div>

    <div class="order-confirmation-back-to-homepage">
        <a href="{{route('home')}}" >@lang('Înapoi pe prima pagină')</a>
    </div>
@endsection
