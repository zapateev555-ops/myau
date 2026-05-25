<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'МоторДеталь') — автозапчасти</title>
    <meta name="description" content="МоторДеталь — интернет-магазин автозапчастей. Каталог, доставка, подбор по артикулу.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-mark.svg') }}">
    <script>
        (function () {
            var t = localStorage.getItem('md-theme');
            if (t === 'light' || t === 'dark') document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></noscript>
    @stack('styles')
</head>
<body class="mp-body">
<div class="mp-wrap">
    <header class="mp-header">
        <div class="mp-container mp-header__row">
            <a href="{{ route('index') }}" class="mp-logo" title="МоторДеталь">
                <img src="{{ asset('images/logo-mark.svg') }}" alt="" class="mp-logo__mark" width="40" height="40" decoding="async">
                <span class="mp-logo__text"><span class="mp-logo__motor">Мотор</span><span class="mp-logo__detal">Деталь</span></span>
            </a>

            <form class="mp-search" action="{{ route('products') }}" method="get" role="search">
                <input type="search" name="q" class="mp-search__input" placeholder="Артикул, название запчасти…" value="{{ request('q') }}" autocomplete="off">
                <button type="submit" class="mp-search__btn">Найти</button>
            </form>

            <div class="mp-header__actions">
                <button type="button" class="mp-theme-btn" data-theme-toggle aria-label="Светлая или тёмная тема" title="Сменить тему">
                    <i class="fas fa-moon mp-theme-btn__icon mp-theme-btn__icon--dark" aria-hidden="true"></i>
                    <i class="fas fa-sun mp-theme-btn__icon mp-theme-btn__icon--light" aria-hidden="true"></i>
                </button>
                @auth
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="mp-admin-btn" title="Админ-панель">ADMIN</a>
                @endif
                <a href="{{ route('cart') }}" class="mp-cart-btn">
                    <i class="fas fa-cart-shopping"></i>
                    <span>Корзина</span>
                    @if($cartItemsCount > 0)<em>{{ $cartItemsCount }}</em>@endif
                </a>
                <a href="{{ route('profile') }}" class="mp-header__link mp-header__link--account d-none d-lg-inline-flex"><i class="fas fa-user"></i><span>Кабинет</span></a>
                @else
                <a href="{{ route('login') }}" class="mp-header__link"><i class="fas fa-right-to-bracket"></i><span>Войти</span></a>
                <a href="{{ route('register') }}" class="mp-header__link d-none d-md-inline-flex">Регистрация</a>
                @endauth
                <button type="button" class="mp-burger d-lg-none" id="mpBurger" aria-label="Меню"><i class="fas fa-bars"></i></button>
            </div>
        </div>

        <nav class="mp-nav" id="mpNav">
            <div class="mp-container mp-nav__inner">
                <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'is-active' : '' }}">Главная</a>
                <a href="{{ route('products') }}" class="{{ request()->routeIs('products', 'product.show') ? 'is-active' : '' }}">Каталог</a>
                <a href="{{ route('services.delivery') }}">Доставка</a>
                <a href="{{ route('services.guarantee') }}">Гарантия</a>
                <a href="{{ route('services.tire-service') }}">СТО</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'is-active' : '' }}">О магазине</a>
                <a href="{{ route('contacts') }}" class="{{ request()->routeIs('contacts*') ? 'is-active' : '' }}">Контакты</a>
            </div>
        </nav>
    </header>

    <div class="mp-alerts mp-container">@include('shop.partials.alerts')</div>

    <main class="mp-main">@yield('content')</main>

    <footer class="mp-footer">
        <div class="mp-container">
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="{{ route('index') }}" class="mp-logo mp-logo--footer mb-3">
                        <img src="{{ asset('images/logo-mark.svg') }}" alt="" class="mp-logo__mark" width="36" height="36" decoding="async">
                        <span class="mp-logo__text"><span class="mp-logo__motor">Мотор</span><span class="mp-logo__detal">Деталь</span></span>
                    </a>
                    <p class="mp-footer__text">Интернет-магазин автозапчастей для легковых и коммерческих автомобилей.</p>
                </div>
                <div class="col-md-4">
                    <h6>Покупателям</h6>
                    <ul class="mp-footer__links">
                        <li><a href="{{ route('services.delivery') }}">Доставка</a></li>
                        <li><a href="{{ route('services.guarantee') }}">Гарантия</a></li>
                        <li><a href="{{ route('offer') }}">Оферта</a></li>
                        <li><a href="{{ route('privacy') }}">Конфиденциальность</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Контакты</h6>
                    <ul class="mp-footer__links">
                        <li><a href="tel:+79991545656">+7 (999) 154-56-56</a></li>
                        <li><a href="mailto:info@motordetal.ru">info@motordetal.ru</a></li>
                        <li>г. Чебоксары, ул. Гаражная, 14</li>
                    </ul>
                </div>
            </div>
            <div class="mp-footer__copy">&copy; {{ date('Y') }} МоторДеталь</div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="{{ asset('js/theme.js') }}?v={{ filemtime(public_path('js/theme.js')) }}" defer></script>
<script src="{{ asset('js/script.js') }}?v={{ filemtime(public_path('js/script.js')) }}" defer></script>
<script defer>
document.getElementById('mpBurger')?.addEventListener('click', function () {
    document.getElementById('mpNav')?.classList.toggle('is-open');
});
</script>
@stack('scripts')
</body>
</html>
