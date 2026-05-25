<aside class="mp-catalog-sidebar">
    <div class="mp-catalog-sidebar__head">Категории</div>
    <ul class="mp-catalog-sidebar__list">
        <li>
            <a href="{{ route('products', ['category' => 'all']) }}" class="mp-catalog-sidebar__link {{ ($currentCategory ?? 'all') === 'all' ? 'is-active' : '' }}">
                Все запчасти
                <span>{{ $categories->sum('products_count') }}</span>
            </a>
        </li>
        @foreach($categories as $category)
        <li>
            <a href="{{ route('products', ['category' => $category->slug]) }}" class="mp-catalog-sidebar__link {{ ($currentCategory ?? '') === $category->slug ? 'is-active' : '' }}">
                <span class="mp-catalog-sidebar__label">{{ $category->name }}</span>
                <span class="mp-catalog-sidebar__count">{{ $category->products_count }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</aside>
