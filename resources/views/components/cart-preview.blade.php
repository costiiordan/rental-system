<div class="cart-preview" data-role="cart-preview" data-cart="{{json_encode($cart->toArray())}}">
    <div class="cart-preview-header">
        <button class="open-cart-preview-button" data-action="toggle-cart-preview">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m256-424-56-56 280-280 280 280-56 56-224-223-224 223Z"/></svg>
        </button>
        <div>
            Ai <span data-role="cart-item-count"></span> produs(e) selectate
        </div>
        <a href="{{route('checkout.index')}}" class="go-to-checkout-button">
            Rezervă produsele
        </a>
    </div>
    <div class="cart-preview-body" data-role="cart-preview-body">
        <ul class="cart-preview-item-list" data-role="cart-items-list-container"></ul>
        <div class="cart-preview-discounts" data-role="cart-discounts"></div>
        <div class="cart-preview-totals">
            <div class="cart-preview-totals-label">Total:</div>
            <div class="cart-preview-totals-value" data-role="cart-total"></div>
        </div>
    </div>
</div>

<template id="cart-preview-item-template">
    <li class="cart-preview-item" data-id="{id}">
        <img src="{{asset('storage/{imagePath}')}}" alt="{name}" class="cart-preview-item-image">
        <div class="selected-item-details">
            <h2 class="selected-item-name">{name}</h2>
            <div class="selected-item-interval">
                <span class="selected-item-from">{fromDate}</span>
                -
                <span class="selected-item-to">{toDate}</span>
            </div>
            <button data-action="remove-cart-item" data-id="{id}" class="remove-selected-item-button">Elimină</button>
        </div>
        <div class="cart-preview-item-price">
            <span class="cart-item-price">{price} RON</span>
        </div>
    </li>
</template>

<template id="cart-preview-discount-template">
    <div class="cart-preview-discount">
        <div class="cart-preview-discount-name">{name}</div>
        <div class="cart-preview-item-price">
            <span class="cart-item-price">-{value} RON</span>
        </div>
    </div>
</template>
