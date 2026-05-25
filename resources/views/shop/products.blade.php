@extends('shop.layouts.app')

@section('title', 'Каталог')

@section('content')
<div class="mp-container mp-catalog-page">
    <nav aria-label="breadcrumb" class="mp-breadcrumb">
        <a href="{{ route('index') }}">Главная</a>
        <span>/</span>
        <span>Каталог</span>
        @if($currentCategory !== 'all')
        <span>/</span>
        <span>{{ $categories->firstWhere('slug', $currentCategory)?->name }}</span>
        @endif
    </nav>

    <div class="mp-catalog-layout">
        @include('shop.partials.catalog_sidebar')

        <div class="mp-catalog-main">
            <div class="mp-catalog-main__head">
                <h1>
                    @if($search)
                    Поиск: «{{ $search }}»
                    @elseif($currentCategory !== 'all')
                    {{ $categories->firstWhere('slug', $currentCategory)?->name }}
                    @else
                    Все автозапчасти
                    @endif
                </h1>
                <span class="mp-catalog-main__count">{{ $products->count() }} {{ $products->count() === 1 ? 'товар' : ($products->count() < 5 ? 'товара' : 'товаров') }}</span>
            </div>

            <div class="mp-chips d-lg-none">
                <a href="{{ route('products', array_filter(['category' => 'all', 'q' => $search ?: null])) }}" class="mp-chip {{ $currentCategory === 'all' ? 'is-active' : '' }}">Все</a>
                @foreach($categories as $category)
                <a href="{{ route('products', array_filter(['category' => $category->slug, 'q' => $search ?: null])) }}" class="mp-chip {{ $currentCategory === $category->slug ? 'is-active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            @if($products->isEmpty())
            <div class="mp-empty">
                <i class="fas fa-box-open"></i>
                <h3>Ничего не найдено</h3>
                <p>Попробуйте другой запрос или категорию</p>
                <a href="{{ route('products') }}" class="btn btn-glow">Сбросить</a>
            </div>
            @else
            <div class="mp-product-grid">
                @foreach($products as $product)
                @include('shop.partials.product_card', ['product' => $product])
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
