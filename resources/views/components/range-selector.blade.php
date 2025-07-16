@php
    $formAction = route('home');
    $formAction = LaravelLocalization::localizeUrl($formAction);
@endphp
<div class="range-selector-container">
        <div class="range-selector" data-role="range-selector">
            <p class="interval-select-text">@lang('În ce perioadă vrei să închiriezi?')</p>
            <form method="GET" action="{{$formAction}}" class="interval-form" data-role="range-selector-form">
                @if ($category !== null)
                    <input type="hidden" name="category" value="{{$category->reference}}" />
                @endif
                <div class="interval-form-date">
                    <span class="interval-form-date-label">@lang('De la:')</span>
                    <div class="interval-form-date-fields">
                        <input type="date" name="from_date" value="{{$fromDate}}" />
                        <select name="from_time">
                            <option value="09:00" @selected($fromTime == '09:00')>09:00</option>
                            <option value="10:00" @selected($fromTime == '10:00')>10:00</option>
                            <option value="11:00" @selected($fromTime == '11:00')>11:00</option>
                            <option value="12:00" @selected($fromTime == '12:00')>12:00</option>
                            <option value="13:00" @selected($fromTime == '13:00')>13:00</option>
                            <option value="14:00" @selected($fromTime == '14:00')>14:00</option>
                            <option value="15:00" @selected($fromTime == '15:00')>15:00</option>
                            <option value="16:00" @selected($fromTime == '16:00')>16:00</option>
                            <option value="17:00" @selected($fromTime == '17:00')>17:00</option>
                            <option value="18:00" @selected($fromTime == '18:00')>18:00</option>
                        </select>
                    </div>
                </div>
                <div class="interval-form-date">
                    <span class="interval-form-date-label">@lang('Până la:')</span>
                    <div class="interval-form-date-fields">
                        <input type="date" name="to_date" value="{{$toDate}}" />
                        <select name="to_time">
                            <option value="09:00" @selected($toTime == '09:00')>09:00</option>
                            <option value="10:00" @selected($toTime == '10:00')>10:00</option>
                            <option value="11:00" @selected($toTime == '11:00')>11:00</option>
                            <option value="12:00" @selected($toTime == '12:00')>12:00</option>
                            <option value="13:00" @selected($toTime == '13:00')>13:00</option>
                            <option value="14:00" @selected($toTime == '14:00')>14:00</option>
                            <option value="15:00" @selected($toTime == '15:00')>15:00</option>
                            <option value="16:00" @selected($toTime == '16:00')>16:00</option>
                            <option value="17:00" @selected($toTime == '17:00')>17:00</option>
                            <option value="18:00" @selected($toTime == '18:00')>18:00</option>
                        </select>
                    </div>
                </div>
                <div class="interval-form-submit">
                    <button type="submit">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </div>
            </form>
        </div>
    </>
</div>
