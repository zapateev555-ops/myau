@extends('shop.layouts.app')
@section('title', 'Гарантия подлинности')

@section('content')
<section class="page-header-gradient page-header--guarantee">
    <div class="container position-relative">
        <div class="service-page-badge mb-3">
            <img src="{{ asset('images/icon-guarantee.svg') }}" alt="Гарантия подлинности" width="36" height="36">
        </div>
        <h1 class="display-6 fw-bold mb-2">Гарантия подлинности</h1>
        <p class="lead mb-0">Только оригинальные шины от официальных поставщиков</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <p class="lead fw-medium ac-content-title">Покупая в Autoclub, вы получаете сертифицированную продукцию с полным пакетом документов.</p>
                <p class="text-muted">Мы работаем напрямую с дистрибьюторами Michelin, Bridgestone, Nokian, Continental и других брендов. Каждая позиция проходит проверку перед отгрузкой: маркировка, год выпуска, целостность протектора и боковины.</p>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Что гарантируем</h3>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="value-card h-100">
                            <div class="benefit-icon benefit-icon--sm mb-2">
                                <img src="{{ asset('images/icon-guarantee.svg') }}" alt="" width="28" height="28">
                            </div>
                            <h4 class="h6 fw-bold">Официальный импорт</h4>
                            <p class="text-muted small mb-0">Товар поставляется через авторизованные каналы, без серых схем.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="value-card h-100">
                            <div class="benefit-icon benefit-icon--sm mb-2"><i class="fas fa-file-contract"></i></div>
                            <h4 class="h6 fw-bold">Документы</h4>
                            <p class="text-muted small mb-0">Счёт, накладная и гарантийный талон производителя при выдаче заказа.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="value-card h-100">
                            <div class="benefit-icon benefit-icon--sm mb-2"><i class="fas fa-barcode"></i></div>
                            <h4 class="h6 fw-bold">Маркировка</h4>
                            <p class="text-muted small mb-0">Проверка DOT-кода и штрихкода перед отправкой клиенту.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="value-card h-100">
                            <div class="benefit-icon benefit-icon--sm mb-2"><i class="fas fa-rotate-left"></i></div>
                            <h4 class="h6 fw-bold">Возврат</h4>
                            <p class="text-muted small mb-0">Обмен или возврат в течение 14 дней при сохранении товарного вида.</p>
                        </div>
                    </div>
                </div>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Как проверить шину</h3>
                <p class="text-muted mb-0">На странице товара указан бренд и размер. При получении сверьте маркировку на боковине с заказом. Если возникли сомнения — свяжитесь с нами, мы предоставим данные поставки.</p>
            </div>
            <div class="col-lg-5">
                @include('shop.services.partials.sidebar', [
                    'highlights' => [
                        'Прямые поставки от дистрибьюторов',
                        'Проверка перед отгрузкой',
                        'Гарантия производителя',
                        'Возврат в течение 14 дней',
                    ],
                ])
            </div>
        </div>
    </div>
</section>
@endsection
