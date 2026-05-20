@extends('admin.layouts.app')
@section('title', 'Дашборд')
@section('page_title', 'Дашборд')

@section('content')
<div class="nx-bento">
    <div class="nx-metric nx-metric--users">
        <div class="nx-metric__icon"><i class="fas fa-users"></i></div>
        <div class="nx-metric__value">{{ $stats['users'] }}</div>
        <div class="nx-metric__label">Пользователей</div>
    </div>
    <div class="nx-metric nx-metric--orders">
        <div class="nx-metric__icon"><i class="fas fa-box"></i></div>
        <div class="nx-metric__value">{{ $stats['orders'] }}</div>
        <div class="nx-metric__label">Заказов</div>
    </div>
    <div class="nx-metric nx-metric--pending">
        <div class="nx-metric__icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="nx-metric__value">{{ $stats['pending_orders'] }}</div>
        <div class="nx-metric__label">Ожидают</div>
    </div>
    <div class="nx-metric nx-metric--revenue">
        <div class="nx-metric__icon"><i class="fas fa-ruble-sign"></i></div>
        <div class="nx-metric__value">{{ number_format($stats['revenue'], 0, ',', ' ') }}</div>
        <div class="nx-metric__label">Выручка, ₽</div>
    </div>
    <div class="nx-metric nx-metric--products">
        <div class="nx-metric__icon"><i class="fas fa-circle-dot"></i></div>
        <div class="nx-metric__value">{{ $stats['products'] }}</div>
        <div class="nx-metric__label">Товаров</div>
    </div>
    <div class="nx-metric nx-metric--messages">
        <div class="nx-metric__icon"><i class="fas fa-inbox"></i></div>
        <div class="nx-metric__value">{{ $stats['unread_messages'] }}</div>
        <div class="nx-metric__label">Писем</div>
    </div>
</div>

<div class="nx-dashboard-grid">
    <div class="nx-panel">
        <div class="nx-panel__head">
            <h2>Последние заказы</h2>
            <a href="{{ route('admin.orders.index') }}" class="nx-btn-accent btn-sm">Все заказы</a>
        </div>
        <div class="nx-panel__body nx-panel__body--flush">
            @if($recentOrders->isNotEmpty())
            <table class="nx-table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Клиент</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Оплата</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user?->name ?? $order->email }}</td>
                        <td>{{ number_format($order->totalCost(), 0, ',', ' ') }} ₽</td>
                        <td><span class="badge status-badge status-{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                        <td>
                            @if($order->paid)
                            <span class="badge" style="background:var(--nx-accent-dim);color:var(--nx-accent)">Оплачен</span>
                            @else
                            <span class="badge bg-secondary">Нет</span>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="nx-btn-outline btn btn-sm">Открыть</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted text-center py-5 mb-0">Заказов пока нет</p>
            @endif
        </div>
    </div>

    <div class="nx-panel">
        <div class="nx-panel__head">
            <h2>Заказы по статусам</h2>
        </div>
        <div class="nx-panel__body">
            <div class="nx-status-list">
                @foreach(\App\Models\Order::STATUSES as $key => $label)
                <div class="nx-status-row">
                    <span>{{ $label }}</span>
                    <span class="badge">{{ $ordersByStatus[$key] ?? 0 }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
