@props(['prices'])
<ul {{ $attributes->merge(['class' => 'bike-prices']) }}>
    @foreach($prices as $price)
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
