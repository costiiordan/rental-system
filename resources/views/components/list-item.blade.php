<li class="bike-list-item" data-role="bike-list-item" data-id="{{$bike->id}}">
    <img src="{{asset('storage/'.$bike->image_path)}}" alt="{{$bike->name}}" class="bike-item-image" data-action="zoom" loading="lazy">
    <div class="bike-item-details">
        <h2>{{$bike->name}}</h2>
        @if($category)
            <div class="category-badge">
                <span class="category-bk-{{$category->reference}}">{{$category->value}}</span>
            </div>
        @endif
        <ul class="bike-attributes">
            @foreach($attributeValues as $attributeValue)
                <li>
                    <span class="bike-attribute-label">{{$attributeValue->attribute->name}}</span>
                    <span class="bike-attribute-value">{{$attributeValue->value}}</span>
                </li>

            @endforeach
        </ul>
        <p class="bike-description">{{$bike->description}}</p>
        <div class="bike-price-container">
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
        </div>
        @if($interval)
            <div class="add-to-cart-container" data-role="add-to-cart-container" data-item-id="{{$bike->id}}">
                <button data-from="{{$interval->from->format('Y-m-d H:i')}}" data-to="{{$interval->to->format('Y-m-d H:i')}}" data-item-id="{{$bike->id}}" data-action="add-to-cart" class="btn-golden rent-bike-button">
                    @lang('Închiriază') <x-duration :from="$interval->from" :to="$interval->to"/> @lang('cu') {{$intervalPrice}} RON
                </button>
                <button data-action="remove-from-cart" data-role="remove-from-cart" class="btn-secondary remove-from-cart-button" data-cart-item-id="">
                    @lang('Renunță la închiriere')
                </button>
            </div>
        @else
            <p class="bike-select-interval-notice">@lang('Selecteaza intervalul pentru a vedea disponibilitatea.')</p>
        @endif
    </div>
</li>
