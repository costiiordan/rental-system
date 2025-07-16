@extends('layout.home')

@section('content')
    <x-range-selector />

    <main>
        <div class="page-wrapper" data-role="page-container" data-route="{{request()->route()->getName()}}">

            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            <h2 class="section-heading">@lang('Categorii de produse')</h2>
            <x-category-navigation />

            <h2 class="section-heading section-heading-products">
                @if ($category)
                    @lang('Produse din categoria') <span class="category-name">{{$category->value}}</span>
                @else
                    @lang('Toate produsele noastre')
                @endif
            </h2>
            <x-list-filters />
            <ul class="bike-list">
            @foreach($bikes as $bike)
                <x-list-item :item="$bike" />
            @endforeach
            </ul>
        </div>
    </main>

    <dialog class="add-to-cart-dialog" data-role="add-to-cart-dialog">
        <p>@lang('Produsul a fost adaugat in cos.')</p>

        <div class="add-to-cart-dialog-actions">
            <button class="add-to-cart-dialog-continue-btn" data-action="close-dialog">@lang('Rezerva si alte produse')</button>
            <a href="{{route('checkout.index')}}" class="add-to-cart-dialog-checkout-btn">@lang('Finalizează comanda')</a>
        </div>
    </dialog>
@endsection

