<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    private function make(string $name, string $cat = 'Cake', int $price = 50000, bool $pub = true): Product
    {
        return Product::create(['name' => $name, 'slug' => Product::uniqueSlug($name), 'category' => $cat, 'price' => $price, 'is_published' => $pub]);
    }

    public function test_home_shows_published_products_with_rupiah_price(): void
    {
        $this->make('Vanilla Cake', 'Cake', 170000);
        $this->get('/')->assertOk()->assertSee('Vanilla Cake')->assertSee('Rp170.000')->assertSee('Manis untuk Setiap Momen');
    }

    public function test_draft_products_are_hidden_everywhere(): void
    {
        $p = $this->make('Rahasia Cake', 'Cake', 1000, false);
        $this->get('/')->assertDontSee('Rahasia Cake');
        $this->get('/produk/'.$p->slug)->assertNotFound();
    }

    public function test_category_filter_works(): void
    {
        $this->make('Kue A', 'Cake');
        $this->make('Kue B', 'Brownies');
        $this->get('/?kategori=Brownies')->assertSee('Kue B')->assertDontSee('Kue A');
    }

    public function test_unknown_category_is_ignored(): void
    {
        $this->make('Kue A', 'Cake');
        $this->get('/?kategori=Hack')->assertOk()->assertSee('Kue A');
    }

    public function test_search_works_and_empty_state_shown(): void
    {
        $this->make('Cheesecake 14cm', 'Cheesecake');
        $this->make('Bento Cake', 'Cake');
        $this->get('/?q=bento')->assertSee('Bento Cake')->assertDontSee('Cheesecake 14cm');
        $this->get('/?q=zzzz')->assertSee('Produk tidak ditemukan');
    }

    public function test_search_treats_wildcards_literally(): void
    {
        $this->make('Kue A');
        $this->get('/?q=%25')->assertSee('Produk tidak ditemukan');
    }

    public function test_whatsapp_button_uses_configured_number_and_product_name(): void
    {
        config(['store.whatsapp' => '6285374748715']);
        $p = $this->make('Bento Cake', 'Cake', 35000);
        $url = $p->whatsappUrl();
        $this->assertStringStartsWith('https://wa.me/6285374748715?text=', $url);
        $this->assertStringContainsString(rawurlencode('Bento Cake'), $url);
        $this->get('/')->assertSee('https://wa.me/6285374748715', false);
    }

    public function test_detail_page_shows_product(): void
    {
        $p = $this->make('Fruit Cake', 'Lainnya', 170000);
        $this->get('/produk/'.$p->slug)->assertOk()->assertSee('Fruit Cake')->assertSee('Rp170.000');
    }

    public function test_address_only_shown_when_configured(): void
    {
        config(['store.address' => null]);
        $this->get('/')->assertDontSee('Lihat di Google Maps');
        config(['store.maps_url' => 'https://maps.example/x']);
        $this->get('/')->assertSee('Lihat di Google Maps');
    }
}
