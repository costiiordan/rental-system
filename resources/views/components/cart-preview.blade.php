<div class="cart-preview" data-role="cart-preview">
    <div class="cart-preview-body" data-role="cart-preview-body">
        <ul class="cart-preview-item-list" data-role="cart-items-list-container"></ul>
        <div class="cart-preview-discounts" data-role="cart-discounts"></div>
        <div class="cart-preview-totals">
            <div class="cart-preview-totals-label">@lang('Total:')</div>
            <div class="cart-preview-totals-value">
                <span data-role="cart-total"></span>
                <span class="cart-preview-totals-value-currency">RON</span>
            </div>
        </div>
    </div>
    <div class="cart-preview-footer" data-role="cart-preview-footer">
        <a href="{{ LaravelLocalization::localizeUrl(route('checkout.index')) }}" class="btn-golden go-to-checkout-button">
            @lang('Finalizează comanda')
        </a>
    </div>
    <div class="empty-cart-message" data-role="empty-cart-message">
        @lang('Coșul tău este gol.')
    </div>
</div>

<template id="cart-preview-item-template">
    <li class="cart-preview-item" data-id="{id}">
        <img src="{{asset('storage/{imagePath}')}}" alt="{name}" class="cart-preview-item-image">
        <div class="cart-preview-item-details">
            <h2 class="cart-preview-item-name">{name}</h2>
            <div class="cart-preview-item-interval">
                @lang('Între')
                <span class="cart-preview-item-from-date">{fromDate}</span>
                -
                <span class="cart-preview-item-to-date">{toDate}</span>
            </div>
            <button data-action="remove-cart-item" data-id="{id}" class="btn-secondary remove-selected-item-button">@lang('Elimină')</button>
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
