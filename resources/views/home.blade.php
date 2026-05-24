@extends('layout.home')

@section('content')
    <x-range-selector />

    <main>
        <div class="page-wrapper">
            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
            @if($category === null)
                <h2 class="section-heading">@lang('Categorii de produse')</h2>
                <x-category-navigation />
                <h2 class="section-heading">@lang('Toate produsele noastre')</h2>
            @else
                <h2 class="section-heading">
                    @lang('Produse din categoria')
                    <span class="category-name">{{$category->value}}</span>
                </h2>
            @endif

            <x-list-filters />

            @if(!$bikes->isEmpty())
                <ul class="bike-list">
                    @foreach($bikes as $bike)
                        <x-list-item :item="$bike" />
                    @endforeach
                </ul>
            @endif
            @if($bikes->isEmpty() && $interval !== null)
                <div class="no-availability-msg">
                    <div class="no-availability-msg-icon">
                        <span class="material-symbols-outlined">sentiment_dissatisfied</span>
                    </div>
                    <div class="no-availability-msg-text">
                        <p>@lang('Nu avem nici un produs disponibil în peroada selectată.')</p>
                        <p>@lang('Iți reamintim că în sezonul 2025 s-a încheiat și facem rezervări începând cu 18 aprilie 2026.')</p>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <x-add-to-cart-dialog />
@endsection

