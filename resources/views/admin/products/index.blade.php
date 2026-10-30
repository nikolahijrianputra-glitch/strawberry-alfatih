@extends('layouts.admin')

@section('title', 'Pengelolaan Produk')

@section('content')
<style>
.sa-products{max-width:1440px;margin:0 auto;color:#39232d}
.sa-products *{box-sizing:border-box}
.sa-products-heading{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-bottom:28px}
.sa-products-heading h1{margin:0 0 8px;font-size:clamp(25px,3vw,34px);font-weight:750;letter-spacing:-1px;color:#38202c}
.sa-products-heading p{margin:0;color:#99828d;font-size:13px;line-height:1.8}
.sa-eyebrow{display:inline-block;margin-bottom:9px;color:#d45c88;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase}
.sa-products-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:43px;padding:11px 17px;border:1px solid transparent;border-radius:12px;background:linear-gradient(135deg,#e85d91,#c83c72);color:#fff;font-size:12px;font-weight:700;text-decoration:none;cursor:pointer;box-shadow:0 7px 18px #d94d801f;transition:.2s}
.sa-products-btn:hover{transform:translateY(-2px);color:#fff;box-shadow:0 10px 24px #d94d8033}
.sa-products-btn-light{background:#fff;border-color:#f1dce5;color:#a93d68;box-shadow:none}
.sa-products-btn-light:hover{background:#fff5f8;color:#a93d68}
.sa-overview{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:25px}
.sa-stat{position:relative;overflow:hidden;padding:21px;border:1px solid #f3e3ea;border-radius:18px;background:linear-gradient(135deg,#fff 55%,#fff3f7);box-shadow:0 7px 25px #7d29450a}
.sa-stat-label{display:block;color:#a18a95;font-size:11px;font-weight:600}
.sa-stat-value{display:block;margin-top:9px;color:#482635;font-size:27px;font-weight:800;letter-spacing:-.7px}
.sa-stat-icon{position:absolute;right:17px;top:17px;display:grid;place-items:center;width:39px;height:39px;border-radius:13px;background:#ffe4ee;color:#cb477b;font-size:19px}
.sa-products-search{display:flex;align-items:center;gap:11px;padding:15px;margin-bottom:22px;border:1px solid #f1e2e9;border-radius:16px;background:#fff;box-shadow:0 6px 22px #7d294507}
.sa-products-search input{flex:1;min-width:0;height:44px;padding:0 14px;border:1px solid #f0e2e8;border-radius:11px;outline:none;background:#fffafd;color:#39232d;font-size:13px}
.sa-products-search input:focus{border-color:#e57ba2;box-shadow:0 0 0 3px #e85d9117}
.sa-products-search input::placeholder{color:#b7a5ad}
.sa-products-card{overflow:hidden;padding:22px;border:1px solid #f1e2e9;border-radius:19px;background:#fff;box-shadow:0 9px 30px #7d294508}
.sa-products-card-heading{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:20px}
.sa-products-card-heading h2{margin:0;color:#422634;font-size:16px;font-weight:800}
.sa-products-card-heading p{margin:6px 0 0;color:#a18b95;font-size:12px}
.sa-products-count{display:inline-flex;align-items:center;padding:7px 12px;border-radius:30px;background:#fff0f5;color:#c34376;font-size:11px;font-weight:800;white-space:nowrap}
.sa-product-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
.sa-product-item{min-width:0;overflow:hidden;border:1px solid #f1e5eb;border-radius:16px;background:#fff;transition:transform .2s,box-shadow .2s,border-color .2s}
.sa-product-item:hover{transform:translateY(-3px);border-color:#efc2d4;box-shadow:0 12px 28px #8d315510}
.sa-product-photo{position:relative;height:190px;overflow:hidden;background:linear-gradient(135deg,#fff1f6,#fae2ec)}
.sa-product-photo img{display:block;width:100%;height:100%;object-fit:cover;transition:transform .35s}
.sa-product-item:hover .sa-product-photo img{transform:scale(1.04)}
.sa-product-no-image{display:flex;align-items:center;justify-content:center;width:100%;height:100%;color:#d27b9c;font-size:12px}
.sa-product-status{position:absolute;top:12px;right:12px;padding:6px 10px;border:1px solid #ffffffb3;border-radius:30px;background:#ffffffed;color:#9b6278;font-size:10px;font-weight:800;backdrop-filter:blur(8px)}
.sa-product-status.is-published{background:#eaf8efed;color:#34794d}
.sa-product-body{padding:16px}
.sa-product-category{display:inline-block;margin-bottom:9px;padding:5px 9px;border-radius:7px;background:#fff0f5;color:#c34a79;font-size:10px;font-weight:700}
.sa-product-name{display:block;min-height:42px;color:#452936;font-size:14px;font-weight:800;line-height:1.5;overflow-wrap:anywhere}
.sa-product-subtext{display:block;margin-top:4px;color:#b09da6;font-size:10px}
.sa-product-price{display:block;margin-top:13px;color:#c64177;font-size:17px;font-weight:800;letter-spacing:-.3px}
.sa-product-actions{display:flex;gap:8px;margin-top:16px;padding-top:13px;border-top:1px solid #f6eaf0}
.sa-product-actions a,.sa-product-actions button{display:inline-flex;align-items:center;justify-content:center;flex:1;min-height:36px;padding:8px 10px;border:1px solid #f0dce5;border-radius:9px;background:#fff;color:#ae426e;font:inherit;font-size:11px;font-weight:750;text-decoration:none;cursor:pointer;transition:.2s}
.sa-product-actions a:hover{background:#fff0f5}
.sa-product-actions form{display:flex;flex:1;margin:0}
.sa-product-actions form button{width:100%}
.sa-product-actions .sa-delete{border-color:#f3dada;color:#bd5056}
.sa-product-actions .sa-delete:hover{background:#fff0ef}
.sa-products-empty{grid-column:1/-1;padding:50px 20px;border:1px dashed #edcfdd;border-radius:15px;color:#a18b95;text-align:center;font-size:13px;line-height:1.8}
.sa-products-empty strong{display:block;margin-bottom:7px;color:#593547;font-size:15px}
.sa-products-pager{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:22px;padding-top:18px;border-top:1px solid #f4e8ee}
.sa-products-pager p{margin:0;color:#a18b95;font-size:12px}
.sa-products-pager-links{display:flex;flex-wrap:wrap;gap:8px}
.sa-products-pager a{display:inline-flex;align-items:center;justify-content:center;min-height:36px;padding:8px 13px;border:1px solid #f0dce5;border-radius:9px;background:#fff;color:#ae426e;font-size:12px;font-weight:700;text-decoration:none}
.sa-products-pager a:hover{background:#fff0f5}
@media(max-width:1050px){.sa-product-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:650px){.sa-products-heading{align-items:flex-start;flex-direction:column}.sa-products-heading .sa-products-btn{width:100%}.sa-overview{gap:9px}.sa-stat{padding:14px 11px}.sa-stat-value{font-size:21px}.sa-stat-icon{position:static;width:30px;height:30px;margin-bottom:12px}.sa-stat-label{font-size:10px}.sa-products-search{flex-wrap:wrap;padding:12px}.sa-products-search input{flex-basis:100%}.sa-products-search .sa-products-btn{flex:1}.sa-products-card{padding:15px}.sa-product-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.sa-product-photo{height:140px}.sa-product-body{padding:11px}.sa-product-name{font-size:12px;min-height:38px}.sa-product-price{font-size:14px}.sa-product-actions{gap:5px}.sa-product-actions a,.sa-product-actions button{padding:7px 5px;font-size:10px}.sa-products-pager{align-items:flex-start;flex-direction:column}}
@media(max-width:370px){.sa-product-grid{grid-template-columns:1fr}.sa-product-photo{height:190px}}
</style>

<div class="sa-products">
    <div class="sa-products-heading">
        <div>
            <span class="sa-eyebrow">Strawberry Alfatih / Management</span>
            <h1>Pengelolaan Produk</h1>
            <p>Kelola katalog dessert dengan mudah dari satu tempat.</p>
        </div>
        <a class="sa-products-btn" href="{{ route('admin.products.create') }}">＋ Tambah Produk</a>
    </div>

    <div class="sa-overview">
        <div class="sa-stat">
            <span class="sa-stat-icon">♡</span>
            <span class="sa-stat-label">Total produk</span>
            <strong class="sa-stat-value">{{ $products->total() }}</strong>
        </div>
        <div class="sa-stat">
            <span class="sa-stat-icon">✿</span>
            <span class="sa-stat-label">Halaman aktif</span>
            <strong class="sa-stat-value">{{ $products->currentPage() }} <span style="font-size:13px;color:#a18b95;font-weight:600">/ {{ $products->lastPage() }}</span></strong>
        </div>
        <div class="sa-stat">
            <span class="sa-stat-icon">✦</span>
            <span class="sa-stat-label">Produk ditampilkan</span>
            <strong class="sa-stat-value">{{ $products->count() }}</strong>
        </div>
    </div>

    <form class="sa-products-search" method="GET" action="{{ route('admin.products.index') }}">
        <input type="search" name="q" value="{{ $q }}" placeholder="⌕  Cari nama produk..." maxlength="60" aria-label="Cari nama produk">
        <button class="sa-products-btn" type="submit">Cari Produk</button>
        @if($q !== '')
            <a class="sa-products-btn sa-products-btn-light" href="{{ route('admin.products.index') }}">Reset</a>
        @endif
    </form>

    <section class="sa-products-card">
        <div class="sa-products-card-heading">
            <div>
                <h2>Koleksi Produk</h2>
                <p>Foto, kategori, harga, dan pengaturan setiap produk.</p>
            </div>
            <span class="sa-products-count">{{ $products->total() }} produk</span>
        </div>

        <div class="sa-product-grid">
            @forelse($products as $p)
                <article class="sa-product-item">
                    <div class="sa-product-photo">
                        @if($p->image_url)
                            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" loading="lazy">
                        @else
                            <div class="sa-product-no-image">Belum ada foto produk</div>
                        @endif
                        <span class="sa-product-status {{ $p->is_published ? 'is-published' : '' }}">
                            {{ $p->is_published ? '● Tayang' : '● Draft' }}
                        </span>
                    </div>
                    <div class="sa-product-body">
                        <span class="sa-product-category">{{ $p->category }}</span>
                        <span class="sa-product-name">{{ $p->name }}</span>
                        <span class="sa-product-subtext">ID produk: {{ $p->id }}</span>
                        <span class="sa-product-price">{{ $p->formatted_price }}</span>
                        <div class="sa-product-actions">
                            <a href="{{ route('admin.products.edit', $p) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Hapus produk &quot;{{ e($p->name) }}&quot;? Tindakan ini tidak bisa dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button class="sa-delete" type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="sa-products-empty">
                    <strong>{{ $q !== '' ? 'Produk tidak ditemukan' : 'Belum ada produk' }}</strong>
                    {{ $q !== '' ? 'Coba gunakan kata kunci pencarian yang berbeda.' : 'Tambahkan produk pertama untuk mulai mengisi katalog.' }}
                </div>
            @endforelse
        </div>

        <div class="sa-products-pager">
            <p>Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk · Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}</p>
            <div class="sa-products-pager-links">
                @if(!$products->onFirstPage())
                    <a href="{{ $products->previousPageUrl() }}">← Sebelumnya</a>
                @endif
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}">Berikutnya →</a>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
