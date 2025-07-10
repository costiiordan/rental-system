@extends('layout.default')

@php
    if ($interval) {
        $fromDate = $interval['from']->format('Y-m-d');
        $fromTime = $interval['from']->format('H:i');
        $toDate = $interval['to']->format('Y-m-d');
        $toTime = $interval['to']->format('H:i');

    } else {
        $fromDate = now()->format('Y-m-d');
        $fromTime = '09:00';
        $toDate = now()->addDay()->format('Y-m-d');
        $toTime = '18:00';
    }
@endphp

@section('content')
    <p class="interval-select-text">{{trans('website.interval_select_text')}}</p>

    <form method="GET" action="{{route('home')}}" class="interval-form">
        <div class="interval-form-date">
            <span class="interval-form-date-label">{{trans('website.interval_select_from')}}</span>
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
            <span class="interval-form-date-label">{{trans('website.interval_select_to')}}</span>
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

    @if(!$interval)
        <p class="select-interval-text">{{trans('website.all_bikes_text')}}</p>
    @endif

    <x-cart-preview/>

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <ul class="bike-list">
    @foreach($bikes as $bike)
        <li class="bike-list-item">
            <img src="{{asset('storage/'.$bike->image_path)}}" alt="{{$bike->name}}" class="bike-item-image" data-action="zoom">
            <div class="bike-item-details">
                <h2>{{$bike->name}}</h2>
                <ul class="bike-attributes">
                    @foreach($bike->attributeValues as $attributeValue)
                        <li>
                            <span class="bike-attribute-label">{{$attributeValue->attribute->name}}</span>
                            <span class="bike-attribute-value">{{$attributeValue->value}}</span>
                        </li>

                    @endforeach
                </ul>
                <p class="bike-description">{{$bike->description}}</p>
                <ul class="bike-prices">
                    @foreach($bike->prices as $price)
                        <li>
                            <span class="bike-price-duration">
                                {{$price->duration}} <x-duration-unit :duration="$price->duration" :duration-unit="$price->duration_unit" />
                            </span>
                            <span class="bike-price-amount">
                                {{$price->price}} <span class="bike-price-currency">RON</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
                @if($interval)
                    <div class="add-to-cart-container">
                        <button data-from="{{$interval['from']->format('Y-m-d H:i')}}" data-to="{{$interval['to']->format('Y-m-d H:i')}}" data-item-id="{{$bike->id}}" data-action="add-to-cart" class="rent-bike-button">
                            {{trans('website.add_to_cart_btn_label_1')}} <x-duration :from="$interval['from']" :to="$interval['to']"/> {{trans('website.add_to_cart_btn_label_2')}} {{$prices[$bike->id]}} RON
                        </button>
                    </div>
                @else
                    <p class="bike-select-interval-notice">{{trans('website.bike_select_interval_notice')}}</p>
                @endif
            </div>
        </li>

    @endforeach
    </ul>

    <dialog class="add-to-cart-dialog" data-role="add-to-cart-dialog">
        <p>Produsul a fost adaugat in cos.</p>

        <div class="add-to-cart-dialog-actions">
            <button class="add-to-cart-dialog-continue-btn" data-action="close-dialog">Rezerva si alte produse</button>
            <a href="{{route('checkout.index')}}" class="add-to-cart-dialog-checkout-btn">Finalizază comanda</a>
        </div>
    </dialog>
@endsection

