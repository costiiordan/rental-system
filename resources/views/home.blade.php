@extends('layout.default')

@php
    if ($interval) {
        $fromDate = $interval->from->format('Y-m-d');
        $fromTime = $interval->from->format('H:i');
        $toDate = $interval->to->format('Y-m-d');
        $toTime = $interval->to->format('H:i');

    } else {
        $fromDate = now()->format('Y-m-d');
        $fromTime = '09:00';
        $toDate = now()->addDay()->format('Y-m-d');
        $toTime = '18:00';
    }
@endphp

@section('content')
    <p class="interval-select-text">@lang('În ce perioadă vrei să închiriezi?')</p>
    @php
    $formAction = $category ? route('category', ['category' => $category]) : route('home');
    $formAction = LaravelLocalization::localizeUrl($formAction);
    @endphp
    <form method="GET" action="{{$formAction}}" class="interval-form">
        <div class="interval-form-date">
            <span class="interval-form-date-label">@lang('De la:')</span>
            <div class="interval-form-date-fields">
                <input type="date" name="from_date" value="{{$fromDate}}" />
                <select name="from_time">
                    <option value="09:00" @selected($fromTime == '09:00')>09:00</option>
                    <option value="10:00" @selected($fromTime == '10:00')>10:00</option>
                    <option value="11:00" @selected($fromTime == '11:00')>11:00</option>
                    <option value="12:00" @selected($fromTime == '12:00')>12:00</option>
                    <option value="13:00" @selected($fromTime == '13:00')>13:00</option>
                    <option value="14:00" @selected($fromTime == '14:00')>14:00</option>
                    <option value="15:00" @selected($fromTime == '15:00')>15:00</option>
                    <option value="16:00" @selected($fromTime == '16:00')>16:00</option>
                    <option value="17:00" @selected($fromTime == '17:00')>17:00</option>
                    <option value="18:00" @selected($fromTime == '18:00')>18:00</option>
                </select>
            </div>
        </div>
        <div class="interval-form-date">
            <span class="interval-form-date-label">@lang('Până la:')</span>
            <div class="interval-form-date-fields">
                <input type="date" name="to_date" value="{{$toDate}}" />
                <select name="to_time">
                    <option value="09:00" @selected($toTime == '09:00')>09:00</option>
                    <option value="10:00" @selected($toTime == '10:00')>10:00</option>
                    <option value="11:00" @selected($toTime == '11:00')>11:00</option>
                    <option value="12:00" @selected($toTime == '12:00')>12:00</option>
                    <option value="13:00" @selected($toTime == '13:00')>13:00</option>
                    <option value="14:00" @selected($toTime == '14:00')>14:00</option>
                    <option value="15:00" @selected($toTime == '15:00')>15:00</option>
                    <option value="16:00" @selected($toTime == '16:00')>16:00</option>
                    <option value="17:00" @selected($toTime == '17:00')>17:00</option>
                    <option value="18:00" @selected($toTime == '18:00')>18:00</option>
                </select>
            </div>
        </div>
        <div class="interval-form-submit">
            <button type="submit">
                <span class="material-symbols-outlined">search</span>
            </button>
        </div>
    </form>

    <x-cart-preview/>

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
        <x-list-item :item="$bike" :interval="$interval" :price="$interval ? $prices[$bike->id] : null" />
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

