<div class="category-navigation">
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('home', ['category' => $category->reference] + $intervalParams) }}" class="category-bk-{{$category->reference}}">
                    {{ $category->value }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
