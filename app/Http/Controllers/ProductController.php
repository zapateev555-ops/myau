<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category', 'all');
        $products = Product::query()->where('available', true)->with('category');

        if ($categorySlug !== 'all') {
            $products->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        return view('shop.products', [
            'products' => $products->latest()->get(),
            'categories' => Category::all(),
            'currentCategory' => $categorySlug,
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->available, 404);

        $relatedProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('available', true)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('shop.product_detail', compact('product', 'relatedProducts'));
    }
}
