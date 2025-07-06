<ul class="checkout-selected-items-list">
    @foreach($selectedItems as $item)
        @if($item['type'] === \App\Models\Constants\SelectedItemType::DISCOUNT)
            {{$item['name']}}
            -{{$item['value']}} RON
        -------------------------------------------------------------
            @continue
        @endif
        <li class="selected-item" >
            <img src="{{ asset('storage/' . $item['item']->image_path) }}" alt="{{ $item['item']->name }}" class="selected-item-image">
            <div class="selected-item-details">
                <h2 class="selected-item-name">{{ $item['item']->name }}</h2>
                <div class="selected-item-interval">
                    <x-date-interval :from="$item['bookingFromDate']" :to="$item['bookingToDate']" />
                </div>
                <div class="selected-item-price">Preț {{ $item['price'] }} RON</div>
            </div>
        </li>
    @endforeach
</ul>
