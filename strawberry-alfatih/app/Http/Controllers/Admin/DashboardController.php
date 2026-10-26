<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Product::count(),
            'published' => Product::published()->count(),
            'draft' => Product::where('is_published', false)->count(),
        ];
        $perCategory = Product::selectRaw('category, count(*) as total')->groupBy('category')->pluck('total', 'category');
        $latest = Product::latest('updated_at')->latest('id')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'perCategory', 'latest'));
    }
}
