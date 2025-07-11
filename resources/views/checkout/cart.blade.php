<div class="checkout-cart-container" data-role="checkout-cart-container">
    <ul class="cart-preview-item-list">
        @foreach($cart->items as $cartItem)
            <li class="cart-preview-item" data-id="{id}">
                <img src="{{asset('storage/'.$cartItem->item->image_path)}}" alt="{{$cartItem->item->name}}" class="cart-preview-item-image">
                <div class="cart-preview-item-details">
                    <h2 class="cart-preview-item-name">{{$cartItem->item->name}}</h2>
                    <div class="cart-preview-item-interval">
                        Între
                        <span class="cart-preview-item-from-date">{{$cartItem->fromDate->format('d.m H:i')}}</span>
                        -
                        <span class="cart-preview-item-to-date">{{$cartItem->toDate->format('d.m H:i')}}</span>
                    </div>
                </div>
                <div class="cart-preview-item-price">
                    <span class="cart-preview-item-price">
                        {{$cartItem->price}}
                        <span class="cart-preview-item-price-currency">RON</span>
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="cart-preview-discounts">
        @foreach($cart->discounts as $discount)
            <div class="cart-preview-discount">
                <div class="cart-preview-discount-name">{{$discount->name}}</div>
                <div class="cart-preview-item-price">
                    <span class="cart-item-price">
                        -{{$discount->value}}
                        <span class="cart-preview-item-price-currency">RON</span>
                    </span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="cart-preview-totals">
        <div class="cart-preview-totals-label">Total:</div>
        <div class="cart-preview-totals-value">
            <span>{{$cart->total}}</span>
            <span class="cart-preview-totals-value-currency">RON</span>
        </div>
    </div>
</div>
