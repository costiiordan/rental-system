@extends('layout.home')

@section('content')
    <main>
        <div class="page-wrapper">
            <h2 class="section-heading">@lang('Listă de prețuri')</h2>

            @if($category === null)
                <x-category-navigation route="price-list" />
            @endif

            <x-list-filters route="price-list" :show-interval="false" />

            @if(!$bikes->isEmpty())
                <ul class="price-list-rows">
                    @foreach($bikes as $bike)
                        <x-price-list-item :item="$bike" />
                    @endforeach
                </ul>
            @endif
        </div>
    </main>
@endsection
