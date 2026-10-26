
@extends('layouts.admin')

@section('title', 'Pengelolaan Produk')

@section('content')
<style>
    .sa-products {
        max-width: 1200px;
        margin: 0 auto;
        color: #382b2b;
    }

    .sa-products * {
        box-sizing: border-box;
    }

    .sa-products-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .sa-products-heading h1 {
        margin: 0 0 7px;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 750;
        letter-spacing: -.7px;
    }

    .sa-products-heading p {
        margin: 0;
        color: #92817c;
        font-size: 13px;
        line-height: 1.7;
    }

    .sa-products-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 11px 17px;
        border: 1px solid transparent;
        border-radius: 10px;
        background: #702b3b;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, transform .2s;
        white-space: nowrap;
    }

    .sa-products-btn:hover {
        background: #51202d;
        color: #fff;
        transform: translateY(-1px);
    }

    .sa-products-btn-light {
        background: #fff;
        border-color: #eadfd8;
        color: #702b3b;
    }

    .sa-products-btn-light:hover {
        background: #faf6f0;
        color: #51202d;
    }

    .sa-products-search {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 17px;
        margin-bottom: 20px;
        border: 1px solid #eee4dc;
        border-radius: 14px;
        background: #fff;
    }

    .sa-products-search input {
        flex: 1;
        min-width: 0;
        height: 43px;
        padding: 0 14px;
        border: 1px solid #e7dcd5;
        border-radius: 10px;
        outline: none;
        background: #fffdfa;
        color: #382b2b;
        font-size: 13px;
    }

    .sa-products-search input:focus {
        border-color: #702b3b;
        box-shadow: 0 0 0 3px rgba(112,43,59,.08);
    }

    .sa-products-search input::placeholder {
        color: #b0a29c;
    }

    .sa-products-card {
        overflow: hidden;
        border: 1px solid #eee4dc;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(73,39,37,.035);
    }

    .sa-products-card-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 22px;
        border-bottom: 1px solid #f0e8e2;
    }

    .sa-products-card-heading h2 {
        margin: 0;
        font-size: 15px;
        font-weight: 750;
    }

    .sa-products-card-heading p {
        margin: 5px 0 0;
        color: #988982;
        font-size: 12px;
    }

    .sa-products-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 20px;
        background: #faf1ed;
        color: #702b3b;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .sa-products-table-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .sa-products-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .sa-products-table th {
        padding: 14px 17px;
        background: #fcf9f5;
        color: #8d7972;
        font-size: 10px;
        font-weight: 750;
        letter-spacing: .7px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .sa-products-table td {
        padding: 15px 17px;
        border-top: 1px solid #f3ece6;
        color: #51413c;
        vertical-align: middle;
    }

    .sa-products-table tbody tr {
        transition: background .15s;
    }

    .sa-products-table tbody tr:hover {
        background: #fdfaf7;
    }

    .sa-products-table .sa-col-price {
        text-align: right;
        white-space: nowrap;
    }

    .sa-product-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 190px;
    }

    .sa-product-thumb {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 54px;
        width: 54px;
        height: 54px;
        overflow: hidden;
        border: 1px solid #eee4dc;
        border-radius: 11px;
        background: #faf6f0;
        color: #ad9385;
        font-size: 10px;
    }

    .sa-product-thumb img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sa-product-name {
        display: block;
        max-width: 240px;
        color: #432f30;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .sa-product-subtext {
        display: block;
        margin-top: 4px;
        color: #a09189;
        font-size: 11px;
    }

    .sa-product-category {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 7px;
        background: #faf5ef;
        color: #82695f;
        font-size: 11px;
        line-height: 1.5;
    }

    .sa-product-price {
        color: #702b3b;
        font-weight: 750;
        font-variant-numeric: tabular-nums;
    }

    .sa-product-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 9px;
        border-radius: 20px;
        background: #f3eee9;
        color: #806f66;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .sa-product-status::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #a99a90;
    }

    .sa-product-status.is-published {
        background: #eaf5ec;
        color: #347148;
    }

    .sa-product-status.is-published::before {
        background: #47955d;
    }

    .sa-product-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
        white-space: nowrap;
    }

    .sa-product-actions a,
    .sa-product-actions button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 34px;
        padding: 7px 10px;
        border: 1px solid #eadfd8;
        border-radius: 8px;
        background: #fff;
        color: #702b3b;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .sa-product-actions a:hover {
        background: #faf1ed;
    }

    .sa-product-actions form {
        display: inline;
        margin: 0;
    }

    .sa-product-actions .sa-delete {
        border-color: #f0dada;
        color: #a13f46;
    }

    .sa-product-actions .sa-delete:hover {
        background: #fff0ef;
    }

    .sa-products-empty {
        padding: 48px 20px !important;
        color: #9a8981 !important;
        text-align: center;
        line-height: 1.8;
    }

    .sa-products-empty strong {
        display: block;
        margin-bottom: 5px;
        color: #594440;
        font-size: 14px;
    }

    .sa-products-pager {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 17px 22px;
        border-top: 1px solid #f0e8e2;
        background: #fffdfa;
    }

    .sa-products-pager p {
        margin: 0;
        color: #988982;
        font-size: 12px;
    }

    .sa-products-pager-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .sa-products-pager a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 35px;
        padding: 8px 12px;
        border: 1px solid #eadfd8;
        border-radius: 8px;
        background: #fff;
        color: #702b3b;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
    }

    .sa-products-pager a:hover {
        background: #faf1ed;
    }

    @media (max-width: 760px) {
        .sa-products-heading {
            align-items: flex-start;
        }

        .sa-products-search {
            padding: 12px;
        }

        .sa-products-card-heading {
            padding: 17px;
        }

        .sa-products-table {
            min-width: 760px;
        }

        .sa-products-pager {
            align-items: flex-start;
            flex-direction: column;
            padding: 15px 17px;
        }
    }

    @media (max-width: 480px) {
        .sa-products-heading {
            flex-direction: column;
        }

        .sa-products-heading .sa-products-btn {
            width: 100%;
        }

        .sa-products-search {
            flex-wrap: wrap;
        }

        .sa-products-search input {
            flex-basis: 100%;
        }

        .sa-products-search .sa-products-btn {
            flex: 1;
        }
    }
</style>

<div class="sa-products">
    <div class="sa-products-heading">
        <div>
            <h1>Pengelolaan Produk</h1>
            <p>Kelola katalog dan informasi produk Strawberry Alfatih.</p>
        </div>

        <a class="sa-products-btn" href="{{ route('admin.products.create') }}">
            <span aria-hidden="true">+</span> Tambah Produk
        </a>
    </div>

    <form class="sa-products-search" method="GET" action="{{ route('admin.products.index') }}">
        <input
            type="search"
            name="q"
            value="{{ $q }}"
            placeholder="Cari nama produk..."
            maxlength="60"
            aria-label="Cari nama produk"
        >

        <button class="sa-products-btn" type="submit">Cari Produk</button>

        @if($q !== '')
            <a class="sa-products-btn sa-products-btn-light"
               href="{{ route('admin.products.index') }}">
                Reset
            </a>
        @endif
    </form>

    <section class="sa-products-card">
        <div class="sa-products-card-heading">
            <div>
                <h2>Daftar Produk</h2>
                <p>Informasi produk yang tersimpan di katalog.</p>
            </div>

            <span class="sa-products-count">
                {{ $products->total() }} produk
            </span>
        </div>

        <div class="sa-products-table-wrap">
            <table class="sa-products-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th class="sa-col-price">Harga</th>
                        <th>Status</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $p)
                        <tr>
                            <td>
                                <div class="sa-product-info">
                                    <div class="sa-product-thumb">
                                        @if($p->image_url)
                                            <img
                                                src="{{ $p->image_url }}"
                                                alt="{{ $p->name }}"
                                                loading="lazy"
                                            >
                                        @else
                                            <span>Tanpa foto</span>
                                        @endif
                                    </div>

                                    <div>
                                        <span class="sa-product-name">{{ $p->name }}</span>
                                        <span class="sa-product-subtext">
                                            ID produk: {{ $p->id }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="sa-product-category">{{ $p->category }}</span>
                            </td>

                            <td class="sa-col-price">
                                <span class="sa-product-price">{{ $p->formatted_price }}</span>
                            </td>

                            <td>
                                <span class="sa-product-status {{ $p->is_published ? 'is-published' : '' }}">
                                    {{ $p->is_published ? 'Tayang' : 'Draft' }}
                                </span>
                            </td>

                            <td>
                                <div class="sa-product-actions">
                                    <a href="{{ route('admin.products.edit', $p) }}">
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.products.destroy', $p) }}"
                                        onsubmit="return confirm('Hapus produk &quot;{{ e($p->name) }}&quot;? Tindakan ini tidak bisa dibatalkan.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="sa-delete" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="sa-products-empty">
                                <strong>
                                    {{ $q !== '' ? 'Produk tidak ditemukan' : 'Belum ada produk' }}
                                </strong>

                                {{ $q !== ''
                                    ? 'Coba gunakan kata kunci pencarian yang berbeda.'
                                    : 'Tambahkan produk pertama untuk mulai mengisi katalog.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="sa-products-pager">
            <p>
                Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
            </p>

            <div class="sa-products-pager-links">
                @if($products->onFirstPage() === false)
                    <a href="{{ $products->previousPageUrl() }}">
                        &larr; Sebelumnya
                    </a>
                @endif

                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}">
                        Berikutnya &rarr;
                    </a>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
