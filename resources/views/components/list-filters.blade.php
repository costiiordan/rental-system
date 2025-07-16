<div class="list-filters">
    @if($category !== null)
        <div class="list-filter-item">
            <span class="list-filter-label">@lang('Categorie:')</span>
            <span class="list-filter-value">{{$category->value}}</span>
            <a class="list-filter-remove-button" href="{{$removeCategoryUrl}}">
                <span class="material-symbols-outlined">close</span>
            </a>
        </div>
    @endif
    @if ($interval !== null)
        <div class="list-filter-item">
            <span class="list-filter-label">@lang('Interval:')</span>
            <span class="list-filter-value">
                {{$interval->from->format('d.m H:i')}}
                -
                {{$interval->from->format('d.m H:i')}}
                (<x-duration :from="$interval->from" :to="$interval->to"/>)
            </span>
            <a class="list-filter-remove-button" href="{{$removeIntervalUrl}}">
                <span class="material-symbols-outlined">close</span>
            </a>
        </div>
    @endif
</div>
