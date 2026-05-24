@props(['item', 'interval' => null, 'intervalError' => null])

@if($interval)
    <div class="item-range-selected">
        <span class="item-range-selected__label">@lang('Perioada selectată:')</span>
        <span class="item-range-selected__value">
            {{ $interval->from->isoFormat('D MMM, HH:mm') }}
            <span class="item-range-selected__arrow">-</span>
            {{ $interval->to->isoFormat('D MMM, HH:mm') }}
        </span>
        <a
            href="{{ LaravelLocalization::localizeUrl(route('item.show', ['item' => $item->sku])) }}"
            class="btn-secondary item-range-selected__reset"
        >
            @lang('Alege alt interval')
        </a>
    </div>
@else
    @php
        $fromDate = now()->format('Y-m-d');
        $fromTime = '09:00';
        $toDate = now()->addDay()->format('Y-m-d');
        $toTime = '17:00';

        $formAction = LaravelLocalization::localizeUrl(route('item.show', ['item' => $item->sku]));

        $timeOptions = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
    @endphp

    <form
        method="GET"
        action="{{ $formAction }}"
        class="item-range-selector"
        data-role="range-selector-form"
    >
        <p class="item-range-selector__heading">@lang('Alege perioada')</p>

        @if(!empty($intervalError))
            <p class="interval-error">{{ $intervalError }}</p>
        @endif

        <div class="item-range-selector__fields">
            <label class="item-range-selector__field">
                <span class="item-range-selector__label">@lang('De la:')</span>
                <div class="item-range-selector__inputs">
                    <input type="date" name="from_date" value="{{ $fromDate }}" />
                    <select name="from_time">
                        @foreach($timeOptions as $time)
                            <option value="{{ $time }}" @selected($fromTime === $time)>{{ $time }}</option>
                        @endforeach
                    </select>
                </div>
            </label>

            <label class="item-range-selector__field">
                <span class="item-range-selector__label">@lang('Până la:')</span>
                <div class="item-range-selector__inputs">
                    <input type="date" name="to_date" value="{{ $toDate }}" />
                    <select name="to_time">
                        @foreach($timeOptions as $time)
                            <option value="{{ $time }}" @selected($toTime === $time)>{{ $time }}</option>
                        @endforeach
                    </select>
                </div>
            </label>
        </div>

        <button type="submit" class="btn-golden item-range-selector__submit">
            <span class="material-symbols-outlined">search</span>
            @lang('Vezi disponibilitatea')
        </button>
    </form>
@endif
