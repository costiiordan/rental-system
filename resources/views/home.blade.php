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

    <x-cart-preview/>

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

                        <button data-from="{{$interval['from']->format('Y-m-d H:i')}}" data-to="{{$interval['to']->format('Y-m-d H:i')}}" data-item-id="{{$bike->id}}" data-action="add-to-cart" class="rent-bike-button">
                            Închiriază
                        </button>
                    </div>
                @endif
            </div>
        </li>

    @endforeach
    </ul>
@endsection

