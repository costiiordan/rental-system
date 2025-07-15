@extends('layout.default')

@section('content')
    <p class="interval-select-text">@lang('În ce perioadă vrei să închiriezi?')</p>

    <x-range-selector />

    @if(!$interval)
        <p class="select-interval-text">@lang('Acestea sunt toate bicicletele noastre. Selecteaza intervalul pentru a vedea ce avem disponibil.')</p>
    @endif

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <x-category-navigation />

    <ul class="bike-list">
    @foreach($bikes as $bike)
        <x-list-item :item="$bike" />
    @endforeach
    </ul>

    <dialog class="add-to-cart-dialog" data-role="add-to-cart-dialog">
        <p>@lang('Produsul a fost adaugat in cos.')</p>

        <div class="add-to-cart-dialog-actions">
            <button class="add-to-cart-dialog-continue-btn" data-action="close-dialog">@lang('Rezerva si alte produse')</button>
            <a href="{{route('checkout.index')}}" class="add-to-cart-dialog-checkout-btn">@lang('Finalizează comanda')</a>
        </div>
    </dialog>
@endsection

