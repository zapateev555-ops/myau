@extends('shop.layouts.app')

@section('title', 'Главная')

@section('content')
<section class="mp-promo">
    <div class="mp-container">
        <div class="mp-promo__box">
            <div>
                <h1>Автозапчасти с доставкой по России</h1>
                <p>Двигатель, тормоза, подвеска, электрика, кузов, расходники — подбор по артикулу и каталогу.</p>
            </div>
            <div class="mp-promo__actions">
                <a href="{{ route('products') }}" class="btn btn-glow">Подобрать запчасти</a>
                <a href="{{ route('contacts') }}" class="btn btn-outline-ac">Помощь менеджера</a>
            </div>
        </div>
    </div>
</section>

@if($featuredProducts->isNotEmpty())
<section class="mp-section mp-section--gray">
    <div class="mp-container">
        <div class="mp-section__head">
            <h2>Хиты продаж</h2>
            <a href="{{ route('products') }}">Весь каталог →</a>
        </div>
        <div class="mp-product-grid">
            @foreach($featuredProducts as $product)
            @include('shop.partials.product_card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
