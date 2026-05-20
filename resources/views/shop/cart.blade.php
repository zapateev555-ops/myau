@extends('shop.layouts.app')
@section('title', 'Корзина')
@section('content')
<div class="container py-5" id="cart-page">
    <div class="text-center mb-4">
        <h1 class="ac-content-title"><i class="fas fa-shopping-cart me-2"></i>Корзина</h1>
        <p class="lead">Выбранные автомобильные шины</p>
    </div>
    @if($cart->items->isNotEmpty())
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4 cart-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table cart-table mb-0">
                            <thead class="ac-card-header-dark">
                                <tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Итого</th><th></th></tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr data-cart-row data-unit-price="{{ $item->product->price }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-photo-wrap product-photo-wrap--cart me-3">
                                                <img src="{{ $item->product->imageUrl() }}" class="product-photo @if($item->product->hasWhiteMatteBackground()) product-photo--matte @endif" alt="">
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->product->category->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">{{ number_format($item->product->price, 0, ',', ' ') }} ₽</td>
                                    <td>
                                        <div class="input-group input-group-sm cart-qty-group">
                                            <button type="button" class="btn btn-qty-step cart-qty-minus" aria-label="Уменьшить">−</button>
                                            <input
                                                type="number"
                                                class="form-control text-center cart-qty-input"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                max="100"
                                                data-item-id="{{ $item->id }}"
                                                data-update-url="{{ route('cart.update', $item) }}"
                                                aria-label="Количество"
                                            >
                                            <button type="button" class="btn btn-qty-step cart-qty-plus" aria-label="Увеличить">+</button>
                                        </div>
                                    </td>
                                    <td class="cart-line-total text-nowrap fw-semibold">{{ number_format($item->totalPrice(), 0, ',', ' ') }} ₽</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">@csrf
                                            <button type="submit" class="btn btn-sm btn-danger" aria-label="Удалить"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm cart-card">
                <div class="card-body">
                    <h5>Итог заказа</h5>
                    <p class="d-flex justify-content-between mb-2"><span>Товары</span><strong id="cart-total">{{ number_format($cart->totalPrice(), 0, ',', ' ') }} ₽</strong></p>
                    <p class="d-flex justify-content-between"><span>Доставка</span><span>Бесплатно</span></p>
                    <hr>
                    <div class="ac-form-actions ac-form-actions--stack">
                        <a href="{{ route('order.create') }}" class="btn btn-accent w-100">Оформить заказ</a>
                        <a href="{{ route('products') }}" class="btn btn-outline-ac w-100">Продолжить покупки</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card text-center py-5 cart-card">
        <div class="card-body">
            <i class="fas fa-shopping-cart fa-4x mb-3" style="color: var(--accent);"></i>
            <h3>Корзина пуста</h3>
            <a href="{{ route('products') }}" class="btn btn-accent mt-3">В каталог</a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endpush
