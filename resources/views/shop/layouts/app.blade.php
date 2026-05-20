<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autoclub') — интернет-магазин автомобильных шин</title>
    <meta name="description" content="Autoclub — интернет-магазин автомобильных шин. Летние, зимние и всесезонные модели с доставкой по России.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body class="ac-body">
<div class="ac-shell">
    <aside class="ac-dock" aria-label="Основная навигация">
        <a href="{{ route('index') }}" class="ac-dock__logo" title="Autoclub">
            <img src="{{ asset('images/logo-mark.svg') }}" alt="Autoclub">
        </a>
        <nav class="ac-dock__nav">
            <a href="{{ route('index') }}" class="ac-dock__link {{ request()->routeIs('index') ? 'is-active' : '' }}" title="Главная">
                <i class="fas fa-house"></i><span>Главная</span>
            </a>
            <a href="{{ route('products') }}" class="ac-dock__link {{ request()->routeIs('products', 'product.show') ? 'is-active' : '' }}" title="Каталог">
                <i class="fas fa-grip"></i><span>Каталог</span>
            </a>
            <a href="{{ route('about') }}" class="ac-dock__link {{ request()->routeIs('about') ? 'is-active' : '' }}" title="О нас">
                <i class="fas fa-circle-info"></i><span>О нас</span>
            </a>
            <a href="{{ route('contacts') }}" class="ac-dock__link {{ request()->routeIs('contacts*') ? 'is-active' : '' }}" title="Контакты">
                <i class="fas fa-paper-plane"></i><span>Контакты</span>
            </a>
            @auth
            <a href="{{ route('cart') }}" class="ac-dock__link {{ request()->routeIs('cart') ? 'is-active' : '' }}" title="Корзина">
                <i class="fas fa-cart-shopping"></i><span>Корзина</span>
                @if($cartItemsCount > 0)
                <span class="ac-dock__badge">{{ $cartItemsCount }}</span>
                @endif
            </a>
            @endauth
        </nav>
        <div class="ac-dock__bottom">
            @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="ac-dock__link ac-dock__link--admin {{ request()->routeIs('admin.*') ? 'is-active' : '' }}" title="Админ-панель">
                <span class="ac-dock__link-icon"><img src="{{ asset('images/logo-mark.svg') }}" alt="" width="20" height="20"></span>
                <span>Админ</span>
            </a>
            @endif
            <a href="{{ route('profile') }}" class="ac-dock__link {{ request()->routeIs('profile*', 'orders', 'order.*') ? 'is-active' : '' }}" title="Профиль">
                <i class="fas fa-user"></i><span>Профиль</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="ac-dock__link {{ request()->routeIs('login', 'register') ? 'is-active' : '' }}" title="Войти">
                <i class="fas fa-right-to-bracket"></i><span>Войти</span>
            </a>
            @endauth
        </div>
    </aside>

    <div class="ac-stage">
        <header class="ac-topbar">
            <a href="{{ route('index') }}"><img src="{{ asset('images/logo.svg') }}" alt="Autoclub" class="ac-brand-logo ac-brand-logo--topbar"></a>
            <span class="ac-topbar__title">Autoclub</span>
            @auth
            <a href="{{ route('cart') }}" class="text-white position-relative">
                <i class="fas fa-cart-shopping fa-lg"></i>
                @if($cartItemsCount > 0)<span class="badge bg-danger position-absolute top-0 start-100 translate-middle">{{ $cartItemsCount }}</span>@endif
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-glow">Войти</a>
            @endauth
        </header>

        <div class="ac-ribbon d-none d-lg-flex">
            <a href="{{ route('services.delivery') }}" class="ac-ribbon__item">
                <img src="{{ asset('images/icon-delivery.svg') }}" alt="" width="18" height="18"> Бесплатная доставка от 10 000 ₽
            </a>
            <a href="{{ route('services.guarantee') }}" class="ac-ribbon__item">
                <img src="{{ asset('images/icon-guarantee.svg') }}" alt="" width="18" height="18"> Гарантия подлинности
            </a>
            <a href="{{ route('services.tire-service') }}" class="ac-ribbon__item">
                <img src="{{ asset('images/icon-tire-service.svg') }}" alt="" width="18" height="18"> Шиномонтаж
            </a>
        </div>

        <div class="ac-alerts">@include('shop.partials.alerts')</div>

        <main class="ac-main">@yield('content')</main>

        <footer class="site-footer">
            <div class="container-fluid px-0">
                <div class="row">
                    <div class="col-lg-4 mb-4 footer-brand">
                        <img src="{{ asset('images/logo.svg') }}" alt="Autoclub" class="ac-brand-logo ac-brand-logo--footer">
                        <p class="small mb-0 mt-2">Интернет-магазин автомобильных шин. Качественная резина для любого сезона.</p>
                    </div>
                    <div class="col-md-4 col-lg-4 mb-4">
                        <h5>Услуги</h5>
                        <p class="mb-2"><a href="{{ route('services.delivery') }}">Доставка</a></p>
                        <p class="mb-2"><a href="{{ route('services.guarantee') }}">Гарантия подлинности</a></p>
                        <p class="mb-0"><a href="{{ route('services.tire-service') }}">Шиномонтаж</a></p>
                    </div>
                    <div class="col-md-4 col-lg-4 mb-4 footer-social">
                        <h5>Контакты</h5>
                        <p class="mb-2"><i class="fas fa-phone me-2"></i> +7 (999) 154-56-56</p>
                        <p class="mb-2"><i class="fas fa-envelope me-2"></i> info@autoclub.ru</p>
                        <p class="mb-3"><i class="fas fa-location-dot me-2"></i> г. Чебоксары, ул. Автомобильная, 10</p>
                        <div class="social-links">
                            <a href="#" aria-label="VK"><i class="fab fa-vk"></i></a>
                            <a href="https://max.ru" target="_blank" rel="noopener noreferrer" class="social-max" aria-label="MAX">
                                <img src="{{ asset('images/icon-max.svg') }}" alt="MAX" width="22" height="22">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pt-4 mt-2 border-top border-secondary border-opacity-25 text-center">
                    <p class="mb-2 small">
                        <a href="{{ route('privacy') }}">Политика конфиденциальности</a>
                        <span class="mx-2 opacity-50">·</span>
                        <a href="{{ route('offer') }}">Публичная оферта</a>
                    </p>
                    <p class="mb-0 small opacity-75">&copy; {{ date('Y') }} Autoclub</p>
                </div>
            </div>
        </footer>
    </div>

    <nav class="ac-dock-mobile d-lg-none" aria-label="Мобильная навигация">
        <a href="{{ route('index') }}" class="ac-dock__link {{ request()->routeIs('index') ? 'is-active' : '' }}"><i class="fas fa-house"></i><span>Главная</span></a>
        <a href="{{ route('products') }}" class="ac-dock__link {{ request()->routeIs('products', 'product.show') ? 'is-active' : '' }}"><i class="fas fa-grip"></i><span>Каталог</span></a>
        @auth
        <a href="{{ route('cart') }}" class="ac-dock__link {{ request()->routeIs('cart') ? 'is-active' : '' }}"><i class="fas fa-cart-shopping"></i><span>Корзина</span></a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="ac-dock__link ac-dock__link--admin {{ request()->routeIs('admin.*') ? 'is-active' : '' }}"><span class="ac-dock__link-icon"><img src="{{ asset('images/logo-mark.svg') }}" alt="" width="20" height="20"></span><span>Админ</span></a>
        @endif
        <a href="{{ route('profile') }}" class="ac-dock__link {{ request()->routeIs('profile*', 'orders', 'order.*') ? 'is-active' : '' }}"><i class="fas fa-user"></i><span>Профиль</span></a>
        @else
        <a href="{{ route('contacts') }}" class="ac-dock__link"><i class="fas fa-paper-plane"></i><span>Контакты</span></a>
        <a href="{{ route('login') }}" class="ac-dock__link"><i class="fas fa-right-to-bracket"></i><span>Войти</span></a>
        @endauth
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>
