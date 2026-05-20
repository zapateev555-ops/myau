@extends('admin.layouts.app')
@section('title', 'Заказ #'.$order->id)
@section('page_title', 'Заказ #'.$order->id)

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header">
                <h5 class="mb-0">Состав заказа</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Товар</th>
                                <th>Категория</th>
                                <th>Цена</th>
                                <th>Кол-во</th>
                                <th>Итого</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->category->name }}</td>
                                <td>{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->cost(), 0, ',', ' ') }} ₽</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Всего</td>
                                <td class="fw-bold">{{ number_format($order->totalCost(), 0, ',', ' ') }} ₽</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0">Доставка</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Получатель:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $order->email }}</p>
                <p class="mb-1"><strong>Адрес:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}</p>
                <p class="mb-0"><strong>Аккаунт:</strong>
                    @if($order->user)
                    <a href="{{ route('admin.users.show', $order->user) }}">{{ $order->user->name }}</a>
                    @else
                    —
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0">Управление заказом</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Статус</label>
                        <select name="status" class="form-select">
                            @foreach(\App\Models\Order::STATUSES as $key => $label)
                            <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Оплата</label>
                        <select name="paid" class="form-select">
                            <option value="1" @selected($order->paid)>Оплачен</option>
                            <option value="0" @selected(!$order->paid)>Не оплачен</option>
                        </select>
                    </div>

                    <p class="small text-muted mb-3">
                        Создан: {{ $order->created_at->format('d.m.Y H:i') }}<br>
                        Способ оплаты: {{ $order->payment_method }}
                    </p>

                    <button type="submit" class="btn btn-accent w-100">Сохранить изменения</button>
                </form>

                <div class="nx-form-actions mt-3">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">← К списку</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="m-0" onsubmit="return confirm('Удалить заказ #{{ $order->id }}? Это действие нельзя отменить.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i>Удалить заказ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
