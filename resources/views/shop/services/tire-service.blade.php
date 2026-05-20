@extends('shop.layouts.app')
@section('title', 'Шиномонтаж')

@section('content')
<section class="page-header-gradient page-header--service">
    <div class="container position-relative">
        <div class="service-page-badge mb-3">
            <img src="{{ asset('images/icon-tire-service.svg') }}" alt="" width="36" height="36">
        </div>
        <h1 class="display-6 fw-bold mb-2">Шиномонтаж и балансировка</h1>
        <p class="lead mb-0">Собственный сервис Autoclub в Чебоксарах</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <p class="lead fw-medium ac-content-title">Купили шины у нас — установим в удобное время на современном оборудовании.</p>
                <p class="text-muted">Сезонная смена, балансировка, ремонт проколов и проверка давления. Мастера с опытом от 5 лет, бережная работа с дисками любого типа — сталь, литые и кованые.</p>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Услуги и цены</h3>
                <div class="service-discount-banner mb-3">
                    <span class="service-discount-banner__badge">−10%</span>
                    <div>
                        <strong>Скидка при покупке 4 шин в Autoclub</strong>
                        <span class="d-block small mt-1">На сезонную смену комплекта — укажите номер заказа или чек при записи</span>
                    </div>
                    <a href="{{ route('products') }}" class="btn btn-sm btn-accent flex-shrink-0">Выбрать шины</a>
                </div>

                <div class="table-responsive service-price-wrap">
                    <table class="table service-price-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Услуга</th>
                                <th scope="col" class="text-end">R13–R16</th>
                                <th scope="col" class="text-end">R17–R18</th>
                                <th scope="col" class="text-end">R19+</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="service-price-table__discount-row">
                                <td>
                                    <span class="fw-semibold">Сезонная смена (4 колеса)</span>
                                    <span class="service-price-table__hint">с комплектом шин из нашего магазина</span>
                                </td>
                                <td class="text-end">
                                    <span class="service-price-old">1 600 ₽</span>
                                    <strong class="service-price-new">1 440 ₽</strong>
                                </td>
                                <td class="text-end">
                                    <span class="service-price-old">2 000 ₽</span>
                                    <strong class="service-price-new">1 800 ₽</strong>
                                </td>
                                <td class="text-end">
                                    <span class="service-price-old">2 400 ₽</span>
                                    <strong class="service-price-new">2 160 ₽</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Балансировка (1 колесо)</td>
                                <td class="text-end">350 ₽</td>
                                <td class="text-end">450 ₽</td>
                                <td class="text-end">550 ₽</td>
                            </tr>
                            <tr>
                                <td>Ремонт прокола</td>
                                <td class="text-end" colspan="3">от 500 ₽</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="small text-muted mt-2 mb-0">Без покупки шин у нас действуют стандартные цены (зачёркнутые) для сезонной смены.</p>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Запись</h3>
                <p class="text-muted">Позвоните <a href="tel:+79991545656">+7 (999) 154-56-56</a> или оставьте заявку на странице <a href="{{ route('contacts') }}">контактов</a>.</p>
            </div>
            <div class="col-lg-5">
                @include('shop.services.partials.sidebar', [
                    'highlights' => [
                        'Современное оборудование',
                        'Запись без очереди',
                        '−10% на монтаж при покупке 4 шин',
                        'ул. Автомобильная, 10',
                    ],
                ])
            </div>
        </div>
    </div>
</section>
@endsection
