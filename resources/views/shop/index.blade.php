@extends('shop.layouts.app')

@section('title', 'Главная')

@section('content')
<section class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="hero-badge mb-3"><i class="fas fa-bolt"></i> Официальный магазин</span>
                <h1 class="hero-title">
                    Резина, которая<br><span class="hero-highlight">держит дорогу</span>
                </h1>
                <p class="lead mb-4" style="max-width: 480px;">Летние, зимние и всесезонные модели с доставкой по России. Подбор, монтаж и гарантия — в одном месте.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products') }}" class="btn btn-lg btn-glow px-4 rounded-0">
                        <i class="fas fa-arrow-right me-2"></i>В каталог
                    </a>
                    <a href="#categories" class="btn btn-lg btn-ghost-light px-4 rounded-0">Категории</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat"><strong>500+</strong><span>моделей</span></div>
                    <div class="hero-stat"><strong>24ч</strong><span>отправка</span></div>
                    <div class="hero-stat"><strong>7 лет</strong><span>опыта</span></div>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="{{ asset('images/tire-placeholder.svg') }}" alt="Шины" class="img-fluid hero-tire-glow" style="max-height: 360px;">
            </div>
        </div>
    </div>
</section>

<section id="categories" class="ac-section ac-section--paper">
    <div class="container-fluid px-lg-5">
        <div class="section-head">
            <span class="section-eyebrow">Ассортимент</span>
            <h2 class="section-title mb-0">Категории</h2>
        </div>
        <div class="ac-cat-scroll-wrap">
        <div class="ac-cat-scroll">
            @php
                $categoryIcons = [
                    'letnie' => 'icon-summer.svg',
                    'zimnie' => 'icon-winter.svg',
                    'vsesezonnye' => 'icon-allseason.svg',
                ];
            @endphp
            @foreach($categories as $category)
            <article class="category-card category-card--{{ $category->slug }}">
                <div class="card-body p-4 text-start">
                    <div class="category-icon-wrap">
                        <img src="{{ asset('images/' . ($categoryIcons[$category->slug] ?? 'tire-placeholder.svg')) }}" alt="{{ $category->name }}">
                    </div>
                    <h3 class="h5 fw-bold mb-1">{{ $category->name }}</h3>
                    <p class="text-muted small mb-3">{{ $category->products_count }} позиций</p>
                    <a href="{{ route('products', ['category' => $category->slug]) }}" class="btn btn-accent btn-sm">Смотреть →</a>
                </div>
            </article>
            @endforeach
        </div>
        </div>
    </div>
</section>

<section class="ac-section ac-section--benefits">
    <div class="container-fluid px-lg-5">
        <div class="section-head text-center text-lg-start">
            <span class="section-eyebrow">Преимущества</span>
            <h2 class="section-title">Почему Autoclub</h2>
            <p class="section-subtitle mx-lg-0">Всё для комфортной и безопасной езды</p>
        </div>
        <div class="ac-bento">
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fas fa-certificate"></i></div>
                <h4 class="fw-bold mb-2">Оригинальная продукция</h4>
                <p class="mb-0 text-muted small">Сертифицированные шины от официальных поставщиков.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon benefit-icon--blue"><i class="fas fa-truck-fast"></i></div>
                <h4 class="fw-bold mb-2">Быстрая доставка</h4>
                <p class="mb-0 text-muted small">Отправка в день оформления по городу и регионам.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon benefit-icon--green"><i class="fas fa-wrench"></i></div>
                <h4 class="fw-bold mb-2">Шиномонтаж</h4>
                <p class="mb-0 text-muted small">Установка и балансировка на собственном сервисе.</p>
            </div>
        </div>
    </div>
</section>
@endsection
