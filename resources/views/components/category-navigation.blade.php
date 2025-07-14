<div class="category-navigation">
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('category', ['category' => $category->reference]) }}" class="category-bk-{{$category->reference}} @if($currentCategoryReference === $category->reference) active @endif">
                    {{ $category->value }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
