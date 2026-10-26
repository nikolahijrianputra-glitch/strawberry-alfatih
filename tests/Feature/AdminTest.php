<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private array $created = [];

    protected function tearDown(): void
    {
        foreach (glob(public_path('uploads/products/*.jpg')) ?: [] as $f) {
            if (preg_match('/^[0-9a-f-]{36}\.jpg$/', basename($f))) {
                @unlink($f);
            }
        }
        parent::tearDown();
    }

    private function admin(): User
    {
        return User::factory()->create();
    }

    private function payload(array $over = []): array
    {
        return array_merge([
            'name' => 'Tes Cake', 'category' => 'Cake', 'price' => '125.000',
            'description' => 'Enak', 'is_published' => '1',
            'image' => UploadedFile::fake()->image('foto.jpg', 800, 600),
        ], $over);
    }

    public function test_guests_cannot_reach_admin(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/products')->assertRedirect('/admin/login');
        $this->get('/admin/products/create')->assertRedirect('/admin/login');
        $this->post('/admin/products', $this->payload())->assertRedirect('/admin/login');
        $this->assertDatabaseCount('products', 0);
    }

    public function test_login_success_and_failure_and_logout(): void
    {
        $u = User::factory()->create(['password' => bcrypt('rahasia-panjang-123')]);
        $this->post('/admin/login', ['email' => $u->email, 'password' => 'salah'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->post('/admin/login', ['email' => $u->email, 'password' => 'rahasia-panjang-123'])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($u);
        $this->get('/admin')->assertOk()->assertSee('Ringkasan');
        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_login_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['email' => 'a@b.test', 'password' => 'x']);
        }
        $this->post('/admin/login', ['email' => 'a@b.test', 'password' => 'x'])->assertStatus(429);
    }

    public function test_create_product_with_image_appears_on_public_catalog(): void
    {
        $this->actingAs($this->admin())->post('/admin/products', $this->payload())->assertRedirect('/admin/products');
        $p = Product::firstOrFail();
        $this->assertSame(125000, $p->price);
        $this->assertSame('tes-cake', $p->slug);
        $this->assertFileExists(public_path('uploads/'.$p->image_path));
        $this->get('/')->assertSee('Tes Cake')->assertSee('Rp125.000');
    }

    public function test_duplicate_names_get_unique_slugs(): void
    {
        $a = $this->actingAs($this->admin());
        $a->post('/admin/products', $this->payload());
        $a->post('/admin/products', $this->payload());
        $this->assertSame(['tes-cake', 'tes-cake-2'], Product::orderBy('id')->pluck('slug')->all());
    }

    public function test_validation_rejects_bad_input(): void
    {
        $a = $this->actingAs($this->admin());
        $a->post('/admin/products', $this->payload(['name' => '']))->assertSessionHasErrors('name');
        $a->post('/admin/products', $this->payload(['category' => 'Narkoba']))->assertSessionHasErrors('category');
        $a->post('/admin/products', $this->payload(['price' => 'abc']))->assertSessionHasErrors('price');
        $a->post('/admin/products', $this->payload(['image' => null]))->assertSessionHasErrors('image');
        $this->assertDatabaseCount('products', 0);
    }

    public function test_upload_rejects_dangerous_and_wrong_files(): void
    {
        $a = $this->actingAs($this->admin());
        $a->post('/admin/products', $this->payload(['image' => UploadedFile::fake()->create('shell.php', 5, 'application/x-php')]))->assertSessionHasErrors('image');
        $a->post('/admin/products', $this->payload(['image' => UploadedFile::fake()->create('x.jpg', 5, 'text/x-php')]))->assertSessionHasErrors('image');
        $a->post('/admin/products', $this->payload(['image' => UploadedFile::fake()->create('doc.pdf', 10, 'application/pdf')]))->assertSessionHasErrors('image');
        $a->post('/admin/products', $this->payload(['image' => UploadedFile::fake()->image('big.jpg')->size(5000)]))->assertSessionHasErrors('image');
        $this->assertDatabaseCount('products', 0);
    }

    public function test_update_changes_data_and_replaces_image(): void
    {
        $a = $this->actingAs($this->admin());
        $a->post('/admin/products', $this->payload());
        $p = Product::firstOrFail();
        $old = public_path('uploads/'.$p->image_path);

        $a->put('/admin/products/'.$p->id, $this->payload(['name' => 'Nama Baru', 'price' => '99000', 'is_published' => '0', 'image' => UploadedFile::fake()->image('baru.png', 500, 500)]))
            ->assertRedirect('/admin/products');
        $p->refresh();
        $this->assertSame('Nama Baru', $p->name);
        $this->assertSame('nama-baru', $p->slug);
        $this->assertFalse($p->is_published);
        $this->assertFileDoesNotExist($old);
        $this->assertFileExists(public_path('uploads/'.$p->image_path));
        $this->get('/')->assertDontSee('Nama Baru');
    }

    public function test_update_without_new_image_keeps_old_image(): void
    {
        $a = $this->actingAs($this->admin());
        $a->post('/admin/products', $this->payload());
        $p = Product::firstOrFail();
        $path = $p->image_path;
        $a->put('/admin/products/'.$p->id, $this->payload(['image' => null, 'price' => '1000']))->assertRedirect('/admin/products');
        $this->assertSame($path, $p->fresh()->image_path);
    }

    public function test_delete_removes_product_and_file(): void
    {
        $a = $this->actingAs($this->admin());
        $a->post('/admin/products', $this->payload());
        $p = Product::firstOrFail();
        $file = public_path('uploads/'.$p->image_path);
        $a->delete('/admin/products/'.$p->id)->assertRedirect('/admin/products');
        $this->assertDatabaseCount('products', 0);
        $this->assertFileDoesNotExist($file);
    }

    public function test_seeder_imports_18_products_and_is_idempotent(): void
    {
        $this->seed();
        $this->assertDatabaseCount('products', 18);
        $this->seed();
        $this->assertDatabaseCount('products', 18);
        $this->assertSame(210000, Product::where('name', 'Burn Cheesecake')->value('price'));
        $this->assertDatabaseCount('users', 0); // tidak ada akun admin bawaan
    }
}
