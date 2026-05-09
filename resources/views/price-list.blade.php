@extends('layout.home')

@section('content')
    <main>
        <div class="page-wrapper">
            <h2 class="section-heading">@lang('Listă de prețuri')</h2>

            <div class="price-list-table-wrapper">
                <table class="price-list-table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>@lang('Nume')</th>
                            <th>@lang('Categorie')</th>
                            @foreach($priceColumns as $column)
                                <th class="price-list-th-price">
                                    {{ $column['duration'] }}
                                    <x-duration-unit :duration="$column['duration']" :duration-unit="$column['duration_unit']" />
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            @php
                                $category = null;
                                foreach ($item->attributeValues as $attributeValue) {
                                    if ($attributeValue->attribute->reference === \App\Models\Constants\AttributeReference::CATEGORY) {
                                        $category = $attributeValue;
                                        break;
                                    }
                                }
                                $priceMap = $item->prices->keyBy(fn ($price) => $price->duration_unit.'_'.$price->duration);
                            @endphp
                            <tr>
                                <td class="price-list-sku">{{ $item->sku }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if($category)
                                        <span class="category-badge">
                                            <span class="category-bk-{{ $category->reference }}">{{ $category->value }}</span>
                                        </span>
                                    @endif
                                </td>
                                @foreach($priceColumns as $column)
                                    @php $price = $priceMap->get($column['duration_unit'].'_'.$column['duration']); @endphp
                                    <td class="price-list-td-price">
                                        @if($price)
                                            <span class="price-list-amount">{{ $price->price }}</span>
                                            <span class="price-list-currency">RON</span>
                                        @else
                                            <span class="price-list-empty">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
