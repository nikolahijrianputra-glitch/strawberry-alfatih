<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Http\Request;
use RuntimeException;

class ProductController extends Controller
{
    public function __construct(private ProductImageService $images) {}

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $products = Product::search($q)->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(['is_published' => true])]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->safe()->except('image');
        $data['slug'] = Product::uniqueSlug($data['name']);

        try {
            $data['image_path'] = $this->images->store($request->file('image'));
        } catch (RuntimeException $e) {
            return back()->withInput()->withErrors(['image' => $e->getMessage()]);
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Produk ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->safe()->except('image');
        if ($data['name'] !== $product->name) {
            $data['slug'] = Product::uniqueSlug($data['name'], $product->id);
        }

        $old = null;
        if ($request->hasFile('image')) {
            try {
                $old = $product->image_path;
                $data['image_path'] = $this->images->store($request->file('image'));
            } catch (RuntimeException $e) {
                return back()->withInput()->withErrors(['image' => $e->getMessage()]);
            }
        }

        $product->update($data);
        $this->images->delete($old);

        return redirect()->route('admin.products.index')->with('status', 'Produk diperbarui.');
    }

    public function destroy(Product $product)
    {
        $path = $product->image_path;
        $product->delete();
        $this->images->delete($path);

        return redirect()->route('admin.products.index')->with('status', 'Produk dihapus.');
    }
}
