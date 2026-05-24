@extends('layout.home')

@section('content')
    <x-range-selector route="item.show" :route-params="['item' => $item->sku]" :always-render="true" />

    <main>
        <div class="page-wrapper">
            @php
                $category = $item->category();
                $attributeValues = $item->nonCategoryAttributeValues();
            @endphp

            <article class="item-detail" data-role="bike-list-item" data-id="{{ $item->id }}">
                <div class="item-detail__image-col">
                    <img
                        src="{{ asset('storage/'.$item->image_path) }}"
                        alt="{{ $item->name }}"
                        class="item-detail__image"
                        data-action="zoom"
                        loading="lazy"
                    >
                </div>

                <div class="item-detail__info-col">
                    <header class="item-detail__header">
                        <h1 class="item-detail__name">{{ $item->name }}</h1>
                        <span class="item-detail__sku">{{ $item->sku }}</span>
                        @if($category)
                            <div class="category-badge">
                                <span class="category-bk-{{ $category->reference }}">{{ $category->value }}</span>
                            </div>
                        @endif
                    </header>

                    @if(!empty($attributeValues))
                        <section class="item-detail__section">
                            <h2 class="item-detail__section-heading">@lang('Specificații')</h2>
                            <ul class="item-detail__attributes">
                                @foreach($attributeValues as $attributeValue)
                                    <li>
                                        <span class="item-detail__attribute-label">{{ $attributeValue->attribute->name }}</span>
                                        <span class="item-detail__attribute-value">{{ $attributeValue->value }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    @if($item->description)
                        <section class="item-detail__section">
                            <h2 class="item-detail__section-heading">@lang('Descriere')</h2>
                            <p class="item-detail__description">{{ $item->description }}</p>
                        </section>
                    @endif

                    <section class="item-detail__section">
                        <h2 class="item-detail__section-heading">@lang('Tarife')</h2>
                        <x-bike-prices :prices="$item->prices" class="item-detail__prices" />
                    </section>

                    <section class="item-detail__section item-detail__booking">
                        @if(!$interval)
                            <p class="bike-select-interval-notice">@lang('Selecteaza intervalul pentru a vedea disponibilitatea.')</p>
                        @elseif($lockedDayHit)
                            <div class="no-availability-msg">
                                <div class="no-availability-msg-icon">
                                    <span class="material-symbols-outlined">sentiment_dissatisfied</span>
                                </div>
                                <div class="no-availability-msg-text">
                                    <p>@lang('Nu avem nici un produs disponibil în peroada selectată.')</p>
                                    <p>@lang('Iți reamintim că în sezonul 2025 s-a încheiat și facem rezervări începând cu 18 aprilie 2026.')</p>
                                </div>
                            </div>
                        @elseif($isAvailable)
                            <div class="add-to-cart-container" data-role="add-to-cart-container" data-item-id="{{ $item->id }}">
                                <button
                                    data-from="{{ $interval->from->format('Y-m-d H:i') }}"
                                    data-to="{{ $interval->to->format('Y-m-d H:i') }}"
                                    data-item-id="{{ $item->id }}"
                                    data-action="add-to-cart"
                                    class="btn-golden rent-bike-button"
                                >
                                    @lang('Închiriază') <x-duration :from="$interval->from" :to="$interval->to"/> @lang('cu') {{ $intervalPrice }} RON
                                </button>
                                <button
                                    data-action="remove-from-cart"
                                    data-role="remove-from-cart"
                                    class="btn-secondary remove-from-cart-button"
                                    data-cart-item-id=""
                                >
                                    @lang('Renunță la închiriere')
                                </button>
                            </div>
                        @else
                            <p class="item-detail__unavailable">@lang('Produsul nu este disponibil în perioada selectată.')</p>
                        @endif
                    </section>
                </div>
            </article>
        </div>
    </main>

    <x-add-to-cart-dialog />
@endsection
