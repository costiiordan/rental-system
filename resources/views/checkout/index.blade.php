@extends('layout.checkout')

@section('content')
    <div>
        <a href="{{route('home')}}">Înapoi</a>
    </div>

    <div class="checkout-container">
        <div class="checkout-form">
            @include('checkout.form')
        </div>
        <div class="checkout-preview">
            @include('checkout.cart')
        </div>
    </div>
@endsection
