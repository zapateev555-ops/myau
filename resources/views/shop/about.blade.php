@extends('shop.layouts.app')
@section('title', 'О магазине')

@section('content')
<div class="mp-container py-4">
    <nav class="mp-breadcrumb mb-3">
        <a href="{{ route('index') }}">Главная</a><span>/</span><span>О магазине</span>
    </nav>
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <h1 class="mb-3" style="color:var(--ink);font-size:24px;font-weight:700;">МоторДеталь</h1>
            <p class="lead" style="font-size:16px;">Интернет-магазин автозапчастей для легковых и коммерческих автомобилей. Каталог, корзина, оформление заказа и доставка по России.</p>
            <p class="text-muted">Подбор по артикулу, консультация менеджера, гарантия на товар и собственное СТО для установки.</p>
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('products') }}" class="btn btn-glow">Каталог</a>
                <a href="{{ route('contacts') }}" class="btn btn-outline-ac">Контакты</a>
            </div>
        </div>
        <div class="col-lg-5">
            <img src="{{ asset('images/categories/dvigatel.jpg') }}" alt="" class="w-100 rounded" style="border:1px solid var(--border);" loading="lazy">
        </div>
    </div>
</div>
@endsection
