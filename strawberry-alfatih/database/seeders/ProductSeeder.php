<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

/**
 * Data awal dari website lama (harga awal, belum dikonfirmasi pemilik toko).
 * Aman dijalankan ulang: produk yang sudah ada (slug sama) TIDAK ditimpa.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Mini Cheese Isi 2', 'Cheesecake', 85000, 'mini-cheese-isi-2'],
            ['Burn Cheesecake 14cm', 'Cheesecake', 110000, 'burn-cheesecake-14cm'],
            ['Cheesecake 14cm', 'Cheesecake', 110000, 'cheesecake-14cm'],
            ['Shortcake 16cm', 'Shortcake', 125000, 'shortcake-16cm'],
            ['Brownies 16cm', 'Brownies', 80000, 'brownies-16cm'],
            ['Shortcake Isi 2', 'Shortcake', 130000, 'shortcake-isi-2'],
            ['Fruit Cake', 'Lainnya', 170000, 'fruit-cake'],
            ['Mini Cheesecake', 'Cheesecake', 38000, 'mini-cheesecake'],
            ['Cheesecake 18cm', 'Cheesecake', 190000, 'cheesecake-18cm'],
            ['Fudgy Brownies 20x20', 'Brownies', 110000, 'fudgy-brownies-20x20'],
            ['Shortcake 12cm', 'Shortcake', 70000, 'shortcake-12cm'],
            ['Fudgy 20x10', 'Brownies', 60000, 'fudgy-20x10'],
            ['Brownies Bulat 20cm', 'Brownies', 120000, 'brownies-bulat-20cm'],
            ['Vanilla Cake', 'Cake', 170000, 'vanilla-cake'],
            ['Bento Cake', 'Cake', 35000, 'bento-cake'],
            ['Bento Double', 'Cake', 85000, 'bento-double'],
            ['Cheesecake 11cm', 'Cheesecake', 70000, 'cheesecake-11cm'],
            ['Burn Cheesecake', 'Cheesecake', 210000, 'burn-cheesecake'],
        ];

        File::ensureDirectoryExists(public_path('uploads/products'));

        foreach ($items as [$name, $category, $price, $file]) {
            if (Product::where('name', $name)->exists()) {
                continue;
            }
            $slug = Product::uniqueSlug($name);
            $src = database_path("seeders/images/{$file}.jpg");
            $dest = public_path("uploads/products/{$file}.jpg");
            if (is_file($src) && ! is_file($dest)) {
                File::copy($src, $dest);
            }
            Product::create([
                'name' => $name, 'slug' => $slug, 'category' => $category, 'price' => $price,
                'description' => null, 'image_path' => "products/{$file}.jpg", 'is_published' => true,
            ]);
        }
    }
}
