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
    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <div class="selected-items-preview" id="selected-items-container">
        <div class="selected-items-preview-header">
            <button class="selected-items-expand-button" id="expand-selected-items">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m256-424-56-56 280-280 280 280-56 56-224-223-224 223Z"/></svg>
            </button>
            <div>
                Ai <span id="selected-products-counter"></span> produs(e) selectate
            </div>
            <a href="{{route('checkout.index')}}" class="selected-items-checkout-button">
                Rezervă produsele
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m480-560-56-56 63-64H320v-80h167l-64-64 57-56 160 160-160 160ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/></svg>
            </a>
        </div>
        <ul class="selected-items-list" data-role="list-container"></ul>
    </div>

    <div>
        <p>În ce perioadă veri sa închiriezi?</p>
        <form>
            <span>De la: </span>
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
            <span>până la: </span>
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
            <button type="submit">Arată biciclete disponibile</button>
        </form>
    </div>

    @if(!$interval)
        <p>Acestea sunt bicicletele noastre. Selecteaza intervalul pentru a vedea ce avem disponibil.</p>
    @endif

    <ul>
    @foreach($bikes as $bike)
        <li class="bike-item">
            <img src="{{asset('storage/'.$bike->image_path)}}" alt="{{$bike->name}}" class="bike-item-image">
            <div class="bike-item-details">
                <h2>{{$bike->name}}</h2>
                <ul>
                    @foreach($bike->attributeValues as $attributeValue)
                        <li>
                            <strong>{{$attributeValue->attribute->name}}:</strong> {{$attributeValue->value}}
                        </li>

                    @endforeach
                </ul>
                <p>{{$bike->description}}</p>
                <ul>
                    @foreach($bike->prices as $price)
                        <li>
                            {{$price->price}} RON / {{$price->duration}} <x-duration-unit :duration="$price->duration" :duration-unit="$price->duration_unit" />
                        </li>
                    @endforeach
                </ul>
                @if($interval)
                    <div>
                        <p>
                            Pretul pentru <x-duration :from="$interval['from']" :to="$interval['to']"/>: {{$prices[$bike->id]}} RON
                        </p>

                        <button data-from="{{$interval['from']->format('Y-m-d H:i')}}" data-to="{{$interval['to']->format('Y-m-d H:i')}}" data-item-id="{{$bike->id}}" data-action="select-bike" class="rent-bike-button">
                            Închiriază
                        </button>
                    </div>
                @endif
            </div>
        </li>

    @endforeach
    </ul>

    <template id="selected-item-preview-template">
        <li class="selected-item" data-id="{id}">
            <img src="{{asset('storage/{imagePath}')}}" alt="{name}" class="selected-item-image">
            <div class="selected-item-details">
                <h2 class="selected-item-name">{name}</h2>
                <div class="selected-item-interval">
                    <span class="selected-item-from">{fromDate}</span>
                    -
                    <span class="selected-item-to">{toDate}</span>
                </div>
                <div class="selected-item-price">Preț {price} RON</div>
                <button data-action="remove-selected-item" data-id="{id}" class="remove-selected-item-button">Elimină</button>
            </div>
        </li>
    </template>
@endsection

