@extends('shop.layouts.app')
@section('title', 'Доставка')

@section('content')
<section class="page-header-gradient page-header--delivery">
    <div class="container position-relative">
        <div class="service-page-badge mb-3">
            <img src="{{ asset('images/icon-delivery.svg') }}" alt="" width="36" height="36">
        </div>
        <h1 class="display-6 fw-bold mb-2">Бесплатная доставка</h1>
        <p class="lead mb-0">От 10 000 ₽ по городу и в регионы России</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <p class="lead fw-medium ac-content-title">Доставим шины быстро и аккуратно — до пункта выдачи или по адресу.</p>
                <p class="text-muted">Заказы от 10 000 ₽ доставляем бесплатно по Чебоксарам. В другие города отправляем транспортными компаниями: СДЭК, Boxberry, ПЭК. Срок и стоимость рассчитываем при оформлении заказа.</p>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Условия</h3>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="value-card h-100">
                            <h4 class="h6 fw-bold">По городу</h4>
                            <p class="text-muted small mb-0">Бесплатно от 10 000 ₽. При меньшей сумме — 490 ₽. Срок 1–2 рабочих дня.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="value-card h-100">
                            <h4 class="h6 fw-bold">По России</h4>
                            <p class="text-muted small mb-0">Отправка в день оплаты. Трек-номер приходит на email и в личный кабинет.</p>
                        </div>
                    </div>
                </div>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Как это работает</h3>
                <ol class="text-muted">
                    <li class="mb-2">Оформите заказ в каталоге и выберите способ доставки.</li>
                    <li class="mb-2">Менеджер подтвердит наличие и сроки.</li>
                    <li class="mb-2">После оплаты передаём заказ в доставку.</li>
                    <li>Получаете шины и при необходимости записываетесь на шиномонтаж.</li>
                </ol>
            </div>
            <div class="col-lg-5">
                @include('shop.services.partials.sidebar', [
                    'highlights' => [
                        'Бесплатно от 10 000 ₽ по городу',
                        'Отправка в день оплаты',
                        'Отслеживание заказа онлайн',
                        'Самовывоз с ул. Автомобильная, 10',
                    ],
                ])
            </div>
        </div>
    </div>
</section>
@endsection
