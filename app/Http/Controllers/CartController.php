<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart()->load('items.product');

        return view('shop.cart', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ])['quantity'];

        $cart = $this->getCart();

        DB::transaction(function () use ($cart, $product, $quantity) {
            $this->mergeDuplicateItems($cart);

            $item = $cart->items()
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($item) {
                $item->increment('quantity', $quantity);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }
        });

        return redirect()
            ->back()
            ->with('success', "Товар «{$product->name}» добавлен в корзину");
    }

    public function update(Request $request, CartItem $item)
    {
        abort_unless($item->cart->user_id === auth()->id(), 403);

        $quantity = (int) $request->validate([
            'quantity' => 'required|integer|min:0|max:100',
        ])['quantity'];
        $cart = $item->cart()->with('items')->first();

        if ($quantity > 0) {
            $item->update(['quantity' => $quantity]);
            $item->refresh()->loadMissing('product');

            if ($request->wantsJson()) {
                return response()->json($this->cartSummaryPayload($cart->fresh(['items']), $item));
            }

            return redirect()->route('cart')->with('success', 'Количество обновлено');
        }

        $item->delete();
        $cart = $cart->fresh(['items']);

        if ($request->wantsJson()) {
            return response()->json([
                'removed' => true,
                'cart_total' => $cart->totalPrice(),
                'cart_items_count' => $cart->items->sum('quantity'),
            ]);
        }

        return redirect()->route('cart')->with('success', 'Товар удалён из корзины');
    }

    /**
     * @return array<string, mixed>
     */
    private function cartSummaryPayload(Cart $cart, CartItem $item): array
    {
        return [
            'quantity' => $item->quantity,
            'line_total' => $item->totalPrice(),
            'cart_total' => $cart->totalPrice(),
            'cart_items_count' => $cart->items->sum('quantity'),
        ];
    }

    public function remove(CartItem $item)
    {
        abort_unless($item->cart->user_id === auth()->id(), 403);
        $item->delete();

        return redirect()->route('cart')->with('success', 'Товар удалён из корзины');
    }

    private function getCart(): Cart
    {
        $userId = auth()->id();
        $carts = Cart::where('user_id', $userId)->orderBy('id')->get();

        if ($carts->isEmpty()) {
            return Cart::create(['user_id' => $userId]);
        }

        $cart = $carts->first();

        if ($carts->count() > 1) {
            foreach ($carts->skip(1) as $extraCart) {
                foreach ($extraCart->items as $item) {
                    $existing = $cart->items()->where('product_id', $item->product_id)->first();

                    if ($existing) {
                        $existing->increment('quantity', $item->quantity);
                        $item->delete();
                    } else {
                        $item->update(['cart_id' => $cart->id]);
                    }
                }

                $extraCart->delete();
            }
        }

        $this->mergeDuplicateItems($cart);

        return $cart->fresh(['items']);
    }

    private function mergeDuplicateItems(Cart $cart): void
    {
        $productIds = $cart->items()
            ->select('product_id')
            ->groupBy('product_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('product_id');

        foreach ($productIds as $productId) {
            $items = $cart->items()->where('product_id', $productId)->orderBy('id')->get();
            $keep = $items->first();
            $extraQuantity = $items->skip(1)->sum('quantity');

            if ($extraQuantity > 0) {
                $keep->increment('quantity', $extraQuantity);
            }

            $cart->items()->whereIn('id', $items->skip(1)->pluck('id'))->delete();
        }
    }
}
