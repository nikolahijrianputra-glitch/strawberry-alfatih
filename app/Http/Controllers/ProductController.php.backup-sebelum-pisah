<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = config('store.categories');
        $active = $request->query('kategori');
        $active = in_array($active, $categories, true) ? $active : null;
        $q = trim((string) $request->query('q', ''));

        $products = Product::published()
            ->when($active, fn ($query) => $query->where('category', $active))
            ->search($q)
            ->orderBy('id')
            ->get();

        return view('products.index', compact('products', 'categories', 'active', 'q'));
    }

    public function show(string $slug)
    {
        $product = Product::published()->where('slug', $slug)->firstOrFail();

        return view('products.show', compact('product'));
    }
}
