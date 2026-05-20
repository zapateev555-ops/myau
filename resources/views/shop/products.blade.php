@extends('shop.layouts.app')

@section('title', 'Каталог')

@section('content')
<div class="catalog-hero text-center">
    <div class="catalog-hero__inner">
        <h1 class="fw-bold display-6 mb-2">Каталог шин</h1>
        <p class="lead mb-0">Более 500 моделей от ведущих производителей</p>
    </div>
</div>

<div class="catalog-toolbar">
    <div>
        <span class="section-eyebrow d-block">Каталог</span>
        <h2 class="section-title mb-0 h4">Все товары</h2>
    </div>
    <div class="dropdown">
        <button class="btn btn-primary-custom dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-sliders me-1"></i> Категория
        </button>
        <ul class="dropdown-menu shadow border-0">
            <li><a class="dropdown-item" href="{{ route('products', ['category' => 'all']) }}">Все</a></li>
            @foreach($categories as $category)
            <li><a class="dropdown-item" href="{{ route('products', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

<div class="ac-page-wrap">
    <div class="d-flex d-md-none flex-nowrap overflow-auto gap-2 mb-4 pb-1">
        <a href="{{ route('products', ['category' => 'all']) }}" class="btn btn-sm btn-primary-custom flex-shrink-0">Все</a>
        @foreach($categories as $category)
        <a href="{{ route('products', ['category' => $category->slug]) }}" class="btn btn-sm btn-outline-ac flex-shrink-0">{{ $category->name }}</a>
        @endforeach
    </div>

    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
            @include('shop.partials.product_card', ['product' => $product])
        </div>
        @empty
        <div class="col-12">
            <div class="benefit-item text-center py-5">
                <div class="benefit-icon mx-auto mb-3"><i class="fas fa-box-open"></i></div>
                <h3 class="fw-bold">Шины не найдены</h3>
                <p class="text-muted mb-4">Попробуйте другую категорию</p>
                <a href="{{ route('products') }}" class="btn btn-accent">Сбросить фильтры</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
