<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::query()
            ->where('available', true)
            ->with('category')
            ->latest()
            ->limit(12)
            ->get();

        return view('shop.index', compact('featuredProducts'));
    }

    public function about()
    {
        return view('shop.about');
    }

    public function privacy()
    {
        return view('shop.legal.privacy');
    }

    public function offer()
    {
        return view('shop.legal.offer');
    }
}
