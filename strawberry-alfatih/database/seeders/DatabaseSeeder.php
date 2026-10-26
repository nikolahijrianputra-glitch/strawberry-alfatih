<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Hanya produk awal. Akun admin dibuat manual: php artisan admin:create */
    public function run(): void
    {
        $this->call(ProductSeeder::class);
    }
}
