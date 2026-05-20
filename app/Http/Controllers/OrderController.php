<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->get();

        return view('shop.orders', compact('orders'));
    }

    public function create()
    {
        $cart = $this->getCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $profile = auth()->user()->profile;
        $user = auth()->user();

        return view('shop.order.create', [
            'cart' => $cart,
            'initial' => [
                'first_name' => explode(' ', $user->name)[0] ?? '',
                'last_name' => explode(' ', $user->name, 2)[1] ?? '',
                'email' => $user->email,
                'address' => $profile?->address ?? '',
                'postal_code' => $profile?->postal_code ?? '',
                'city' => $profile?->city ?? '',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'address' => 'required|string|max:250',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
        ]);

        $cart = $this->getCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart');
        }

        $order = Order::create([
            ...$data,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'paid' => false,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ]);
        }

        $cart->items()->delete();

        return redirect()
            ->route('order.show', $order)
            ->with('success', 'Заказ успешно оформлен!');
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load('items.product.category');

        return view('shop.order.detail', compact('order'));
    }

    public function payment(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_if($order->paid, 403);

        return view('shop.order.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $request->validate([
            'card_number' => 'required|string',
            'card_name' => 'required|string',
            'card_expiry' => 'required|string',
            'card_cvv' => 'required|string',
        ]);

        $order->update(['paid' => true, 'status' => 'processing']);

        return redirect()
            ->route('order.show', $order)
            ->with('success', 'Оплата прошла успешно! Заказ передан в обработку.');
    }

    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }
}
