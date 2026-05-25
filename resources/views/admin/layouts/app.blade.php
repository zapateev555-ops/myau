<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ-панель') — МоторДеталь</title>
    <script>
        (function () {
            if (localStorage.getItem('md-theme') === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    @stack('styles')
</head>
<body class="nx-body">
<div class="nx-app">
    <header class="nx-command">
        <a href="{{ route('admin.dashboard') }}" class="nx-command__brand">
            <img src="{{ asset('images/logo-mark.svg') }}" alt="">
            <span>
                <em>Панель управления</em>
                <span class="nx-brand-motor">Мотор</span><span class="nx-brand-detal">Деталь</span>
            </span>
        </a>

        <button type="button" class="nx-mobile-toggle" id="nx-nav-toggle" aria-label="Меню">
            <i class="fas fa-bars"></i>
        </button>

        <nav class="nx-tabs" id="nx-tabs">
            <a href="{{ route('admin.dashboard') }}" class="nx-tab {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <i class="fas fa-chart-pie"></i> Дашборд
            </a>
            <a href="{{ route('admin.users.index') }}" class="nx-tab {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
                <i class="fas fa-users"></i> Пользователи
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nx-tab {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}">
                <i class="fas fa-box"></i> Заказы
            </a>
            <a href="{{ route('admin.products.index') }}" class="nx-tab {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">
                <i class="fas fa-circle-dot"></i> Товары
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="nx-tab {{ request()->routeIs('admin.contacts.*') ? 'is-active' : '' }}">
                <i class="fas fa-inbox"></i> Сообщения
            </a>
        </nav>

        <div class="nx-command__end">
            <button type="button" class="nx-icon-btn nx-theme-btn" data-theme-toggle aria-label="Сменить тему" title="Сменить тему">
                <i class="fas fa-moon nx-theme-btn__icon nx-theme-btn__icon--dark" aria-hidden="true"></i>
                <i class="fas fa-sun nx-theme-btn__icon nx-theme-btn__icon--light" aria-hidden="true"></i>
            </button>
            <form action="{{ route('logout') }}" method="POST" class="nx-logout-form">@csrf
                <button type="submit" class="nx-icon-btn nx-logout-btn" title="Выйти" aria-label="Выйти">
                    <i class="fas fa-right-from-bracket" aria-hidden="true"></i>
                </button>
            </form>
            <a href="{{ route('index') }}" class="nx-site-link" title="На сайт">
                <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i>
                <span>На сайт</span>
            </a>
        </div>
    </header>

    <div class="nx-workspace">
        @if(session('success'))
        <div class="nx-alert nx-alert--success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="nx-alert nx-alert--error alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @hasSection('page_title')
        <div class="nx-page-head">
            <div>
                <div class="nx-breadcrumb">МоторДеталь / Admin</div>
                <h1>@yield('page_title')</h1>
            </div>
            @yield('page_actions')
        </div>
        @endif

        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/theme.js') }}?v={{ filemtime(public_path('js/theme.js')) }}" defer></script>
<script>
document.getElementById('nx-nav-toggle')?.addEventListener('click', function () {
    document.getElementById('nx-tabs')?.classList.toggle('is-open');
});
</script>
@stack('scripts')
</body>
</html>
