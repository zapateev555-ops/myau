@extends('shop.layouts.app')
@section('title', 'Контакты')
@section('content')
<div class="mp-container py-4">
    <nav class="mp-breadcrumb mb-3">
        <a href="{{ route('index') }}">Главная</a><span>/</span><span>Контакты</span>
    </nav>

    <div class="page-header-gradient mb-4">
        <h1 class="h4 fw-bold mb-2">Контакты МоторДеталь</h1>
        <p class="mb-3 small">Подбор по артикулу и VIN, вопросы по доставке и СТО</p>
        <div class="d-flex flex-wrap gap-2">
            <a href="tel:+79991545656" class="btn btn-glow btn-sm"><i class="fas fa-phone me-1"></i>+7 (999) 154-56-56</a>
            <a href="mailto:info@motordetal.ru" class="btn btn-outline-light btn-sm">info@motordetal.ru</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="contact-card h-100">
                <h3 class="h6 fw-bold">Адрес</h3>
                <p class="contact-card__text mb-0 small">г. Чебоксары, ул. Гаражная, 14<br>ТЦ «АвтоМолл», 1 этаж</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="contact-card h-100">
                <h3 class="h6 fw-bold">Связь</h3>
                <p class="mb-1 small"><a href="tel:+79991545656">+7 (999) 154-56-56</a></p>
                <p class="mb-0 small"><a href="mailto:info@motordetal.ru">info@motordetal.ru</a></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="contact-card h-100">
                <h3 class="h6 fw-bold">Режим</h3>
                <p class="mb-0 small">Ежедневно 9:00 – 20:00</p>
            </div>
        </div>
    </div>

    <div class="contact-card">
        <h2 class="h5 fw-bold mb-3">Напишите нам</h2>
        <form method="POST" action="{{ route('contacts.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Имя</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Телефон</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Сообщение</label>
                    <textarea name="message" class="form-control" rows="4" placeholder="Артикул, марка авто…" required>{{ old('message') }}</textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-glow">Отправить</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
