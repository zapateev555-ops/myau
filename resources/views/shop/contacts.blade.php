@extends('shop.layouts.app')
@section('title', 'Контакты')
@section('content')
<section class="page-header-gradient page-header--contacts">
    <div class="container position-relative">
        <div class="row align-items-end g-4">
            <div class="col-lg-7">
                <p class="contacts-hero__eyebrow mb-2">Связь с магазином</p>
                <h1 class="display-6 fw-bold mb-3">Контакты Autoclub</h1>
                <p class="lead mb-4">Подберём шины, ответим на вопросы по доставке и шиномонтажу — звоните или оставьте заявку.</p>
                <div class="contacts-hero__actions d-flex flex-wrap gap-2">
                    <a href="tel:+79991545656" class="btn btn-glow">
                        <i class="fas fa-phone me-2"></i>+7 (999) 154-56-56
                    </a>
                    <a href="mailto:info@autoclub.ru" class="btn btn-outline-ac">
                        <i class="fas fa-envelope me-2"></i>info@autoclub.ru
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contacts-hero__hours">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Ежедневно 9:00–20:00</strong>
                        <span>ТЦ «АвтоМолл», 1 этаж</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Как нас найти</h2>
            <p class="section-subtitle mb-0">Магазин в Чебоксарах — приезжайте на консультацию и подбор</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="benefit-icon benefit-icon--blue">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Адрес</h3>
                    <p class="contact-card__text mb-0">г. Чебоксары, ул. Автомобильная, 10<br>ТЦ «АвтоМолл», 1 этаж</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card contact-card--accent">
                    <div class="benefit-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Телефон и почта</h3>
                    <ul class="contact-card__list list-unstyled mb-0">
                        <li><a href="tel:+79991545656">+7 (999) 154-56-56</a></li>
                        <li><a href="mailto:info@autoclub.ru">info@autoclub.ru</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="benefit-icon benefit-icon--green">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Режим работы</h3>
                    <p class="contact-card__text mb-2">Понедельник — воскресенье</p>
                    <p class="contact-card__highlight mb-0">9:00 – 20:00</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contacts-form-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="contacts-form-card">
                    <div class="contacts-form-card__head text-center">
                        <h2 class="section-title mb-2">Напишите нам</h2>
                        <p class="section-subtitle mb-0">Ответим в течение рабочего дня</p>
                    </div>
                    <form method="POST" action="{{ route('contacts.store') }}" class="contacts-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Имя</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Как к вам обращаться" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Телефон</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+7 (___) ___-__-__">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Сообщение</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Размер шин, марка авто или другой вопрос" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12 text-center pt-2">
                                <button type="submit" class="btn btn-accent btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Отправить сообщение
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
