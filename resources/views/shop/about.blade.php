@extends('shop.layouts.app')
@section('title', 'О нас')

@section('content')
<section class="page-header-gradient page-header--about">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <img src="{{ asset('images/logo.svg') }}" alt="Autoclub" class="ac-brand-logo ac-brand-logo--hero">
                <h1 class="display-6 fw-bold mb-2">О компании Autoclub</h1>
                <p class="lead mb-0">Интернет-магазин автомобильных шин с профессиональным подбором и установкой</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <p class="lead fw-medium ac-content-title">С 2018 года помогаем водителям выбрать надёжную резину для любого сезона.</p>
                <p class="text-muted">Подбор по марке авто, размеру и стилю езды. Консультация специалистов, быстрая доставка и собственный шиномонтаж — всё в одном месте.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <div class="ac-form-actions">
                        <a href="{{ route('products') }}" class="btn btn-glow">Каталог</a>
                        <a href="{{ route('contacts') }}" class="btn btn-outline-ac">Контакты</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/tire-placeholder.svg') }}" class="img-fluid hero-tire-glow" style="max-height: 280px;" alt="Шины">
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: var(--light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Наши ценности</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card">
                    <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                    <h4 class="fw-bold">Качество</h4>
                    <p class="text-muted mb-0">Только сертифицированные шины от проверенных брендов.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="benefit-icon benefit-icon--blue"><i class="fas fa-headset"></i></div>
                    <h4 class="fw-bold">Сервис</h4>
                    <p class="text-muted mb-0">Консультация по подбору размера и сезонности.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="benefit-icon benefit-icon--green"><i class="fas fa-ruble-sign"></i></div>
                    <h4 class="fw-bold">Цены</h4>
                    <p class="text-muted mb-0">Честные цены и акции для постоянных клиентов.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
