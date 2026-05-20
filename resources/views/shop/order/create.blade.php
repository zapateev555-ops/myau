@extends('shop.layouts.app')
@section('title', 'Оформление заказа')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header ac-card-header-dark">
                    <h4 class="mb-0">Оформление заказа</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-4">
                        <thead><tr><th>Товар</th><th>Кол-во</th><th>Итого</th></tr></thead>
                        <tbody>
                            @foreach($cart->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->totalPrice(), 0, ',', ' ') }} ₽</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot><tr><td colspan="2" class="text-end fw-bold">Всего:</td><td class="fw-bold">{{ number_format($cart->totalPrice(), 0, ',', ' ') }} ₽</td></tr></tfoot>
                    </table>
                    <form method="POST" action="{{ route('order.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Имя</label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $initial['first_name']) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Фамилия</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $initial['last_name']) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $initial['email']) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Адрес</label>
                                <textarea name="address" class="form-control" rows="2" required>{{ old('address', $initial['address']) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Индекс</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $initial['postal_code']) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Город</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $initial['city']) }}" required>
                            </div>
                            <div class="col-12">
                                <div class="ac-form-actions ac-form-actions--stack">
                                    <button type="submit" class="btn btn-accent">Перейти к оплате</button>
                                    <a href="{{ route('cart') }}" class="btn btn-outline-ac">В корзину</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
