<div class="card h-100 product-card">
    <div class="position-relative">
        <a href="{{ route('product.show', $product) }}" class="product-photo-wrap product-photo-wrap--card d-block">
            <img src="{{ $product->imageUrl() }}" class="product-photo @if($product->hasWhiteMatteBackground()) product-photo--matte @endif" alt="{{ $product->name }}">
        </a>
        @if($product->price < 7000)
        <span class="badge badge-deal position-absolute top-0 start-0 m-2">Выгодно</span>
        @endif
    </div>
    <div class="card-body">
        <h5 class="card-title mb-1">
            <a href="{{ route('product.show', $product) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
        </h5>
        <p class="card-text text-muted small mb-3">
            <i class="fas fa-tag me-1 opacity-50"></i>{{ $product->category->name }}
        </p>
        <div class="d-flex justify-content-between align-items-center">
            <span class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
            @auth
            <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-sm btn-accent px-3" title="В корзину">
                    <i class="fas fa-cart-plus me-1"></i>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-ac px-3" title="Войдите для покупки">
                <i class="fas fa-cart-plus"></i>
            </a>
            @endauth
        </div>
    </div>
</div>
