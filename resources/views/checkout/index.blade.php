@extends('layout.default')

@section('content')
    <div class="checkout-top-bar">
        <a class="btn-secondary checkout-top-bar-btn checkout-back-button" href="{{route('home')}}">
            <span class="material-symbols-outlined">chevron_backward</span>
            <span>@lang('Înapoi')</span>
        </a>

        <button class="btn-secondary checkout-top-bar-btn checkout-view-cart-button" data-action="toggle-cart-preview">
            <span class="material-symbols-outlined">stat_1</span>
            <span>@lang('Vezi coșul')</span>
        </button>
    </div>

    <div class="checkout-container">
        <div class="checkout-preview">
            @include('checkout.cart')
        </div>
        <div class="checkout-form">
            @include('checkout.form')
        </div>
    </div>
@endsection
