<li class="bike-list-item">
    <img src="{{asset('storage/'.$bike->image_path)}}" alt="{{$bike->name}}" class="bike-item-image" data-action="zoom" loading="lazy">
    <div class="bike-item-details">
        @if($category)
            <div class="category-badge">
                <span class="category-bk-{{$category->reference}}">{{$category->value}}</span>
            </div>
        @endif
        <h2>{{$bike->name}}</h2>
        <ul class="bike-attributes">
            @foreach($attributeValues as $attributeValue)
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
                <button data-from="{{$interval->from->format('Y-m-d H:i')}}" data-to="{{$interval->to->format('Y-m-d H:i')}}" data-item-id="{{$bike->id}}" data-action="add-to-cart" class="rent-bike-button">
                    @lang('Închiriază') <x-duration :from="$interval->from" :to="$interval->to"/> @lang('cu') {{$intervalPrice}} RON
                </button>
            </div>
        @else
            <p class="bike-select-interval-notice">@lang('Selecteaza intervalul pentru a vedea disponibilitatea.')</p>
        @endif
    </div>
</li>
