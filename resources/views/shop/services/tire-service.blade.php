@extends('shop.layouts.app')
@section('title', 'СТО и установка')

@section('content')
<section class="page-header-gradient page-header--service">
    <div class="mp-container position-relative">
        <div class="service-page-badge mb-3">
            <i class="fas fa-screwdriver-wrench fa-2x"></i>
        </div>
        <h1 class="display-6 fw-bold mb-2">СТО и установка запчастей</h1>
        <p class="lead mb-0">Собственный сервис МоторДеталь в Чебоксарах</p>
    </div>
</section>

<section class="py-5">
    <div class="mp-container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-7">
                <p class="lead fw-medium ac-content-title">Купили запчасти у нас — установим на сертифицированном оборудовании.</p>
                <p class="text-muted">Замена тормозных колодок и дисков, амортизаторов, фильтров, свечей, жидкостей и других узлов. Мастера с опытом от 5 лет, работа по регламенту производителя.</p>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Услуги и ориентиры по цене</h3>
                <div class="service-discount-banner mb-3">
                    <span class="service-discount-banner__badge">−15%</span>
                    <div>
                        <strong>Скидка на работы при покупке запчастей в МоторДеталь</strong>
                        <span class="d-block small mt-1">Укажите номер заказа при записи на СТО</span>
                    </div>
                    <a href="{{ route('products') }}" class="btn btn-sm btn-accent flex-shrink-0">В каталог</a>
                </div>

                <div class="table-responsive service-price-wrap">
                    <table class="table service-price-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Услуга</th>
                                <th scope="col" class="text-end">Легковые</th>
                                <th scope="col" class="text-end">Кроссовер / SUV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Замена масла и фильтра</td>
                                <td class="text-end">от 890 ₽</td>
                                <td class="text-end">от 1 190 ₽</td>
                            </tr>
                            <tr>
                                <td>Замена передних колодок</td>
                                <td class="text-end">от 1 490 ₽</td>
                                <td class="text-end">от 1 890 ₽</td>
                            </tr>
                            <tr>
                                <td>Замена амортизатора (1 шт.)</td>
                                <td class="text-end">от 1 290 ₽</td>
                                <td class="text-end">от 1 690 ₽</td>
                            </tr>
                            <tr>
                                <td>Замена свечей зажигания (4 шт.)</td>
                                <td class="text-end">от 990 ₽</td>
                                <td class="text-end">от 1 290 ₽</td>
                            </tr>
                            <tr>
                                <td>Диагностика ходовой</td>
                                <td class="text-end" colspan="2">от 790 ₽</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="small text-muted mt-2 mb-0">Точная стоимость зависит от модели авто и объёма работ — рассчитаем при записи.</p>

                <h3 class="h5 fw-bold mt-4 mb-3 ac-content-title">Запись</h3>
                <p class="text-muted">Позвоните <a href="tel:+79991545656">+7 (999) 154-56-56</a> или оставьте заявку на странице <a href="{{ route('contacts') }}">контактов</a>.</p>
            </div>
            <div class="col-lg-5">
                @include('shop.services.partials.sidebar', [
                    'highlights' => [
                        'Установка купленных у нас запчастей',
                        'Сертифицированное оборудование',
                        '−15% на работы с заказом',
                        'ул. Гаражная, 14',
                    ],
                ])
            </div>
        </div>
    </div>
</section>
@endsection
