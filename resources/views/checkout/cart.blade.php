<ul class="cart-preview-item-list">
    @foreach($cart->items as $cartItem)
        <li class="cart-preview-item" data-id="{id}">
            <img src="{{asset('storage/'.$cartItem->item->image_path)}}" alt="{{$cartItem->item->name}}" class="cart-preview-item-image">
            <div class="selected-item-details">
                <h2 class="selected-item-name">{{$cartItem->item->name}}</h2>
                <div class="selected-item-interval">
                    <span class="selected-item-from">{{$cartItem->fromDate}}</span>
                    -
                    <span class="selected-item-to">{{$cartItem->toDate}}</span>
                </div>
            </div>
            <div class="cart-preview-item-price">
                <span class="cart-item-price">{{$cartItem->price}} RON</span>
            </div>
        </li>
    @endforeach
</ul>
<div class="cart-preview-discounts">
    @foreach($cart->discounts as $discount)
        <div class="cart-preview-discount">
            <div class="cart-preview-discount-name">{{$discount->name}}</div>
            <div class="cart-preview-item-price">
                <span class="cart-item-price">-{{$discount->value}} RON</span>
            </div>
        </div>
    @endforeach
</div>
<div class="cart-preview-totals">
    <div class="cart-preview-totals-label">Total:</div>
    <div class="cart-preview-totals-value">{{$cart->total}}</div>
</div>
