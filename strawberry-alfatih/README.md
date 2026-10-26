# Strawberry Alfatih — Katalog Online (Laravel 13)

Website katalog cake & dessert dengan pemesanan lewat WhatsApp dan dashboard admin untuk mengelola produk.
Stack: Laravel 13, PHP 8.3+, MySQL/MariaDB, Blade, CSS/JS biasa (tanpa Vite/Node).

## Fitur
- Homepage (hero, katalog, tentang kami, footer), halaman detail produk
- Filter kategori dan pencarian (diproses di server, data dari database)
- Tombol pesan WhatsApp dengan pesan otomatis berisi nama dan harga produk
- Admin `/admin`: login, ringkasan, daftar/tambah/edit/hapus produk (hapus dengan konfirmasi), upload & ganti foto, logout
- Status tayang/draft per produk (draft tidak tampil di website)

## Struktur penting
```
app/Http/Controllers/ProductController.php          katalog publik
app/Http/Controllers/Admin/{Auth,Dashboard,Product}Controller.php
app/Http/Requests/ProductRequest.php                validasi produk + upload
app/Services/ProductImageService.php                proses & simpan foto
app/Models/Product.php | app/Support/Whatsapp.php
app/Console/Commands/CreateAdmin.php                php artisan admin:create
config/store.php                                    nomor WA, alamat, kategori
database/migrations | database/seeders (+ images/)  tabel produk & 18 produk awal
resources/views/{layouts,products,partials,admin}   tampilan Blade
public/{css,js,assets,uploads}                      aset (uploads = foto produk)
tests/Feature                                       tes otomatis
```

## Instalasi di Windows (Laragon)
1. Pasang Laragon (Full) — sudah berisi PHP, MySQL, Composer. Pastikan PHP **8.3 atau lebih baru**
   (Laragon → Menu → PHP → pilih versi 8.3+). Ekstensi `gd`, `mbstring`, `fileinfo`, `pdo_mysql` aktif (default Laragon).
2. Ekstrak ZIP ke `C:\laragon\www\strawberry-alfatih`.
3. Buka Laragon → **Start All**, lalu **Terminal** (Cmder) dan jalankan:
   ```
   cd C:\laragon\www\strawberry-alfatih
   composer install
   copy .env.example .env
   php artisan key:generate
   ```
4. Buat database MySQL (pilih salah satu):
   - Laragon → **Database** (HeidiSQL) → klik kanan → Create new → Database → nama `strawberry_alfatih`, collation `utf8mb4_unicode_ci`; atau
   - di terminal: `mysql -u root -e "CREATE DATABASE strawberry_alfatih CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"`
5. Cek `.env`: `DB_DATABASE=strawberry_alfatih`, `DB_USERNAME=root`, `DB_PASSWORD=` (kosong di Laragon default).
6. Migrasi + data awal:
   ```
   php artisan migrate --seed
   ```
   Seeder memasukkan 18 produk awal beserta foto. Aman dijalankan ulang (tidak menimpa produk yang sudah ada).
7. Buat akun admin pertama (password diketik saat diminta, minimal 12 karakter, tidak ada password bawaan):
   ```
   php artisan admin:create
   ```
8. Jalankan:
   - Laragon otomatis membuat alamat `http://strawberry-alfatih.test` (Menu → Apache → Reload, atau Stop/Start All), atau
   - `php artisan serve` lalu buka `http://127.0.0.1:8000` (ubah `APP_URL` di `.env` bila perlu).
9. Admin: `/admin` (mis. `http://strawberry-alfatih.test/admin`).

Tidak perlu `php artisan storage:link`: foto disimpan langsung di `public/uploads/products`.

## Menjalankan tes
```
composer test
```
(menjalankan PHPUnit; `composer install` sudah memasang PHPUnit & Mockery). Tes memakai SQLite in-memory — ekstensi `pdo_sqlite` harus aktif (default di Laragon).

## Konfigurasi toko
Semua lewat `.env` (lihat `.env.example`):
`STORE_WHATSAPP` (format `6285374748715`), `STORE_ADDRESS`, `STORE_MAPS_URL`. Alamat/Maps baru tampil di footer jika diisi.
Daftar kategori ada di `config/store.php`. Harga & produk diubah lewat dashboard admin.
Harga awal belum dikonfirmasi pemilik toko — periksa di admin sebelum website dipublikasikan. Deskripsi produk awal kosong (tidak dikarang); isi lewat admin.

## Deployment ke shared hosting
Syarat hosting: PHP 8.3+ (ekstensi gd, mbstring, fileinfo, pdo_mysql, openssl, tokenizer, xml, ctype), MySQL/MariaDB, dan idealnya SSH atau Composer.

**Cara A — document root ke `public` (disarankan)**
1. Di komputer lokal: `composer install --no-dev --optimize-autoloader` (dan tes sudah lulus).
2. Unggah seluruh proyek (termasuk `vendor/`, **tanpa** `.env` lokal) ke satu folder di atas web root, mis. `/home/USER/strawberry-alfatih`.
3. Di panel hosting, ubah Document Root domain ke `/home/USER/strawberry-alfatih/public`.
4. Buat database + user MySQL di panel hosting. Salin `.env.example` menjadi `.env` di server dan isi: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-anda`, `DB_*`, `SESSION_SECURE_COOKIE=true`, `FORCE_HTTPS=true`.
5. Lewat SSH (atau Terminal panel): `php artisan key:generate --force`, `php artisan migrate --force --seed`, `php artisan admin:create`, lalu `php artisan config:cache && php artisan route:cache && php artisan view:cache`.
6. Izin tulis (775/755 sesuai host) untuk `storage/`, `bootstrap/cache/`, dan `public/uploads/products/`.
7. Aktifkan SSL (Let's Encrypt) di panel.

**Cara B — hosting tidak bisa mengubah document root**
1. Unggah folder proyek (tanpa isi `public/`) ke `/home/USER/laravel-app` (di luar `public_html`).
2. Salin isi folder `public/` ke `public_html/` (termasuk `.htaccess`, `assets`, `css`, `js`, `uploads`).
3. Edit `public_html/index.php`: ubah `__DIR__.'/../vendor/autoload.php'`, `__DIR__.'/../storage/framework/maintenance.php'`, dan `__DIR__.'/../bootstrap/app.php'` menjadi `__DIR__.'/../laravel-app/...'`.
4. Edit `app/Providers/AppServiceProvider.php` bila perlu atau jalankan `php artisan` seperti Cara A. Pastikan `.env` ada di `laravel-app/` (bukan di `public_html`).
5. Foto upload tersimpan di `public_html/uploads/products` jika `public_path()` diarahkan ke sana — tambahkan di `bootstrap/app.php` setelah `->create()`:
   `$app->usePublicPath('/home/USER/public_html');` (ganti sesuai path asli).

**Jangan** mengunggah seluruh Laravel ke `public_html` tanpa langkah di atas — `.env` bisa terbaca publik.
Jangan pernah menjalankan `migrate:fresh` di production. Cadangkan database sebelum update.

## Daftar yang harus diganti sebelum production
- `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` baru (`php artisan key:generate`), `APP_URL` HTTPS
- Kredensial `DB_*` dan password admin yang kuat (bukan dari contoh)
- `SESSION_SECURE_COOKIE=true`, `FORCE_HTTPS=true`
- `STORE_ADDRESS`, `STORE_MAPS_URL` (jika sudah ada), konfirmasi harga & deskripsi produk
- Pastikan `.env` tidak ikut terunggah ke tempat publik / repositori

## Batasan saat ini
- Katalog menampilkan semua produk tayang dalam satu halaman (tanpa paginasi); admin memakai paginasi 15 produk.
- Upload foto membutuhkan ekstensi PHP GD.
- Font Cormorant Garamond & Poppins dimuat dari Google Fonts (perlu internet pengunjung; ada font cadangan).

## Status pengujian (jujur)
Sudah dijalankan di lingkungan pengembangan (PHP 8.3.6, Laravel 13, MariaDB 10.11):
- 20 tes otomatis PHPUnit lulus (katalog publik, filter, pencarian, WhatsApp, autentikasi, rate limit login, CRUD produk, validasi & penolakan upload berbahaya, seeder).
- `php artisan migrate --seed` pada MariaDB berhasil (18 produk, 18 foto); `php artisan admin:create` berhasil.
- Uji HTTP nyata (`php artisan serve` + curl): halaman publik, filter, pencarian, login salah/benar, route admin terlindungi, upload foto valid tampil di katalog, upload file PHP berkedok JPG ditolak, hapus produk ikut menghapus file, POST tanpa token CSRF ditolak (419).

**Belum teruji:**
- `composer install` dari Packagist dan instalasi di Laragon/Windows (di lingkungan pengembangan Packagist tidak dapat diakses, dependensi diambil dari repositori resmi GitHub). `composer.lock` sengaja tidak disertakan; akan dibuat otomatis saat `composer install` pertama — sebaiknya commit file itu setelahnya.
- Aturan `public/uploads/.htaccess` pada Apache/LiteSpeed sungguhan, dan deployment di shared hosting nyata.
- Tampilan di browser sungguhan untuk halaman admin dan halaman detail produk (tidak ada screenshot yang diperiksa), serta pemuatan Google Fonts.
- Klik tombol WhatsApp ke aplikasi WhatsApp (hanya format tautan `wa.me` yang diperiksa).
