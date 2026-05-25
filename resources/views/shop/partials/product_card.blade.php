<article class="mp-tile">
    <a href="{{ route('product.show', $product) }}" class="mp-tile__photo">
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy" decoding="async">
    </a>
    <div class="mp-tile__body">
        <a href="{{ route('product.show', $product) }}" class="mp-tile__name">{{ $product->name }}</a>
        <div class="mp-tile__meta">
            <span class="mp-tile__cat">{{ $product->category->name }}</span>
            <span class="mp-tile__sku">{{ strtoupper(str_replace('-', ' ', $product->slug)) }}</span>
        </div>
        <div class="mp-tile__stock"><i class="fas fa-check-circle"></i> В наличии</div>
        <div class="mp-tile__price-row">
            <span class="mp-tile__price">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
        </div>
        @auth
        <form action="{{ route('cart.add', $product) }}" method="POST" class="mp-tile__form">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="mp-tile__buy">В корзину</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="mp-tile__buy mp-tile__buy--muted">Войти для заказа</a>
        @endauth
    </div>
</article>
