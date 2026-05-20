<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return view('shop.index', compact('categories'));
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
