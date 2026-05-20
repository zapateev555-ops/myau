@extends('admin.layouts.app')
@section('title', $user->name)
@section('page_title', 'Пользователь: '.$user->name)

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                @if($user->is_admin)
                <span class="badge bg-dark mb-2">Администратор</span>
                @endif
                <p class="mb-1"><i class="fas fa-envelope me-2 text-muted"></i>{{ $user->email }}</p>
                <p class="mb-1"><i class="fas fa-phone me-2 text-muted"></i>{{ $user->profile?->phone ?? '—' }}</p>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $user->profile?->city ?? '—' }}</p>
                <p class="mb-0 small text-muted">Зарегистрирован: {{ $user->created_at->format('d.m.Y H:i') }}</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary mt-3">← К списку</a>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0">Заказы пользователя</h5>
            </div>
            <div class="card-body p-0">
                @if($user->orders->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>№</th>
                                <th>Дата</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th>Оплата</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ number_format($order->totalCost(), 0, ',', ' ') }} ₽</td>
                                <td><span class="badge status-badge status-{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                                <td>{{ $order->paid ? 'Оплачен' : 'Не оплачен' }}</td>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Открыть</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center py-4 mb-0">Заказов нет</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
