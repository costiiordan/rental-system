<div class="cart-preview" data-role="cart-preview" data-cart="{{json_encode($cart->toArray())}}">
    <div class="cart-preview-header">
        <div class="cart-preview-summary">
            <button class="open-cart-preview-button" data-action="toggle-cart-preview">
                <span class="material-symbols-outlined">stat_1</span>
            </button>
            <div class="cart-preview-text">
                Ai <span data-role="cart-item-count"></span> produs(e) selectate
            </div>
        </div>
        <a href="{{route('checkout.index')}}" class="go-to-checkout-button">
            Finzează comanda
        </a>
    </div>
    <div class="cart-preview-body" data-role="cart-preview-body">
        <ul class="cart-preview-item-list" data-role="cart-items-list-container"></ul>
        <div class="cart-preview-discounts" data-role="cart-discounts"></div>
        <div class="cart-preview-totals">
            <div class="cart-preview-totals-label">Total:</div>
            <div class="cart-preview-totals-value">
                <span data-role="cart-total"></span>
                <span class="cart-preview-totals-value-currency">RON</span>
            </div>
        </div>
    </div>
</div>

<template id="cart-preview-item-template">
    <li class="cart-preview-item" data-id="{id}">
        <img src="{{asset('storage/{imagePath}')}}" alt="{name}" class="cart-preview-item-image">
        <div class="cart-preview-item-details">
            <h2 class="cart-preview-item-name">{name}</h2>
            <div class="cart-preview-item-interval">
                Între
                <span class="cart-preview-item-from-date">{fromDate}</span>
                -
                <span class="cart-preview-item-to-date">{toDate}</span>
            </div>
            <button data-action="remove-cart-item" data-id="{id}" class="remove-selected-item-button">Elimină</button>
        </div>
        <div class="cart-preview-item-price">
            <span class="cart-preview-item-price">{price} <span class="cart-preview-item-price-currency">RON</span></span>
        </div>
    </li>
</template>

<template id="cart-preview-discount-template">
    <div class="cart-preview-discount">
        <div class="cart-preview-discount-name">{name}</div>
        <div class="cart-preview-item-price">
            <span class="cart-item-price">-{value} <span class="cart-preview-item-price-currency">RON</span></span>
        </div>
    </div>
</template>
