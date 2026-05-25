@extends('shop.layouts.app')
@section('title', $product->name)
@section('content')
<div class="mp-container py-4">
    <nav class="mp-breadcrumb mb-3">
        <a href="{{ route('index') }}">Главная</a><span>/</span>
        <a href="{{ route('products') }}">Каталог</a><span>/</span>
        <a href="{{ route('products', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a><span>/</span>
        <span>{{ $product->name }}</span>
    </nav>

    <div class="row g-4">
        <div class="col-lg-5">
            <div style="background:var(--paper);border:1px solid var(--border);border-radius:var(--radius);padding:20px;">
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-100" style="max-height:360px;object-fit:contain;" loading="eager" decoding="async">
            </div>
        </div>
        <div class="col-lg-7">
            <div style="background:var(--paper);border:1px solid var(--border);border-radius:var(--radius);padding:20px;">
                <div class="text-muted small mb-1">{{ $product->category->name }}</div>
                <h1 class="mb-3" style="font-size:22px;font-weight:700;color:var(--ink);">{{ $product->name }}</h1>
                <div class="mp-product-tile__price mb-3" style="font-size:28px;">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
                <p class="mb-4">{{ $product->description }}</p>
                @auth
                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex align-items-center gap-2 flex-wrap">
                    @csrf
                    <div class="input-group" style="width:120px;">
                        <button class="btn btn-outline-ac minus-btn" type="button">−</button>
                        <input type="number" name="quantity" value="1" min="1" max="100" class="form-control text-center quantity-input">
                        <button class="btn btn-outline-ac plus-btn" type="button">+</button>
                    </div>
                    <button type="submit" class="btn btn-glow flex-grow-1"><i class="fas fa-cart-shopping me-2"></i>В корзину</button>
                </form>
                @else
                <div class="alert alert-info"><a href="{{ route('login') }}">Войдите</a>, чтобы добавить в корзину</div>
                @endauth
                <ul class="list-unstyled small text-muted mt-4 mb-0">
                    <li class="mb-1"><i class="fas fa-check text-success me-2"></i>В наличии</li>
                    <li class="mb-1"><i class="fas fa-truck me-2"></i>Доставка 1–3 дня</li>
                    <li><i class="fas fa-undo me-2"></i>Возврат 14 дней</li>
                </ul>
            </div>
        </div>
    </div>

    @if($relatedProducts->isNotEmpty())
    <section class="mt-5">
        <h2 class="mb-3" style="font-size:18px;font-weight:700;">Похожие запчасти</h2>
        <div class="mp-product-grid">
            @foreach($relatedProducts as $related)
            @include('shop.partials.product_card', ['product' => $related])
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
