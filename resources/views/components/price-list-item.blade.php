<li class="price-list-row">
    <img src="{{asset('storage/'.$bike->image_path)}}" alt="{{$bike->name}}" class="price-list-row__image" loading="lazy">
    <div class="price-list-row__info">
        <h3 class="price-list-row__name">{{$bike->name}}</h3>
        @if($bike->sku)
            <span class="price-list-row__sku">{{$bike->sku}}</span>
        @endif
        @if($category)
            <div class="category-badge">
                <span class="category-bk-{{$category->reference}}">{{$category->value}}</span>
            </div>
        @endif
    </div>
    <x-bike-prices :prices="$bike->prices" class="price-list-row__prices" />
</li>
