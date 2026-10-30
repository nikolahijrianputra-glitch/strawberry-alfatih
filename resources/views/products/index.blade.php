@extends('layouts.app')

@section('title', 'Katalog Produk - Strawberry Alfatih')

@section('content')
<style>
/* KATALOG BARU STRAWBERRY ALFATIH */
.katalog-soft {
    background: #fffaf8 !important;
    padding: 55px 0 70px !important;
    color: #46363a;
}

.katalog-soft .container {
    max-width: 1280px;
    width: calc(100% - 36px);
    margin: 0 auto;
}

.katalog-soft .section-head {
    text-align: center;
    margin-bottom: 35px;
}

.katalog-soft .section-head h2 {
    color: #7c3048;
    font-size: clamp(27px, 3vw, 38px);
    font-weight: 700;
    margin-bottom: 10px;
}

.katalog-soft .section-head p {
    color: #8c777b;
    font-size: 14px;
}

.katalog-soft .tools {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 28px;
}

.katalog-soft .filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.katalog-soft .chip {
    display: inline-flex;
    padding: 9px 15px;
    border: 1px solid #f0dce1;
    border-radius: 30px;
    background: white;
    color: #8b5262;
    text-decoration: none;
    font-size: 13px;
}

.katalog-soft .chip.active {
    background: #a63f5d;
    border-color: #a63f5d;
    color: white;
}

.katalog-soft .search {
    flex: 0 1 260px;
}

.katalog-soft .search input {
    box-sizing: border-box;
    width: 100%;
    padding: 11px 15px;
    border: 1px solid #ead9de;
    border-radius: 25px;
    background: white;
    outline-color: #c96b85;
}

.katalog-soft .grid {
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 22px !important;
    align-items: stretch;
}

.katalog-soft .card {
    display: flex !important;
    flex-direction: column !important;
    min-width: 0;
    height: 100%;
    overflow: hidden;
    border: 1px solid #f0e5e7 !important;
    border-radius: 14px !important;
    background: #fff !important;
    box-shadow: 0 4px 16px rgba(90, 40, 55, .055) !important;
    transition: transform .2s ease, box-shadow .2s ease;
}

.katalog-soft .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(90, 40, 55, .12) !important;
}

.katalog-soft .card-img {
    display: block;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #f9edef;
    border-radius: 0 !important;
}

.katalog-soft .card-img img {
    display: block;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.katalog-soft .card-img .ph {
    display: flex;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    font-size: 42px;
}

.katalog-soft .card-body {
    display: flex !important;
    flex: 1;
    flex-direction: column !important;
    align-items: stretch;
    gap: 9px;
    padding: 15px !important;
}

.katalog-soft .tag {
    align-self: flex-start;
    padding: 5px 9px;
    border-radius: 5px !important;
    background: #fff1f3;
    color: #a14c64;
    font-size: 11px;
}

.katalog-soft .card h3 {
    margin: 0;
    color: #51343d;
    font-size: 15px;
    line-height: 1.5;
    font-weight: 600;
}

.katalog-soft .price {
    margin-top: auto;
    padding-top: 8px;
    color: #a63f5d !important;
    font-size: 15px;
    font-weight: 700;
}

.katalog-soft .card .btn-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    box-sizing: border-box;
    margin-top: 5px;
    padding: 11px;
    border: 0;
    border-radius: 8px !important;
    background: #a63f5d !important;
    color: white !important;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

.katalog-soft .card .btn-primary:hover {
    background: #853049 !important;
}

.katalog-soft .empty,
.katalog-soft .note {
    color: #8c777b;
    text-align: center;
    font-size: 13px;
    margin-top: 25px;
}

@media (min-width: 701px) and (max-width: 1050px) {
    .katalog-soft .grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 16px !important;
    }
}

@media (max-width: 700px) {
    .katalog-soft {
        padding: 35px 0 45px !important;
    }

    .katalog-soft .container {
        width: calc(100% - 24px);
    }

    .katalog-soft .section-head {
        margin-bottom: 24px;
    }

    .katalog-soft .tools {
        align-items: stretch;
    }

    .katalog-soft .search {
        flex-basis: 100%;
    }

    .katalog-soft .grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 12px !important;
    }

    .katalog-soft .card {
        border-radius: 10px !important;
    }

    .katalog-soft .card-body {
        padding: 10px !important;
        gap: 7px;
    }

    .katalog-soft .card h3 {
        font-size: 13px;
    }

    .katalog-soft .price {
        font-size: 13px;
    }

    .katalog-soft .card .btn-primary {
        padding: 9px 5px;
        font-size: 12px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .katalog-soft .card {
        transition: none;
    }
}
</style>
<section class="section katalog-soft" id="katalog">
  <div class="container">
    <div class="section-head">
      <h2>Favorit Pelanggan</h2>
      <p>Pilihan kue yang paling sering dipesan. Pilih kategori, lalu pesan langsung lewat WhatsApp.</p>
    </div>
    <div class="tools">
      <div class="filters" role="group" aria-label="Filter kategori">
        @foreach(array_merge(['Semua'], $categories) as $c)
          @php($on = ($c === 'Semua' && !$active) || $c === $active)
          <a class="chip {{ $on ? 'active' : '' }}" aria-pressed="{{ $on ? 'true' : 'false' }}"
             href="{{ route('katalog', array_filter(['kategori' => $c === 'Semua' ? null : $c, 'q' => $q ?: null])) }}#katalog">{{ $c }}</a>
        @endforeach
      </div>
      <form class="search" method="GET" action="{{ route('katalog') }}" role="search">
        @if($active)<input type="hidden" name="kategori" value="{{ $active }}">@endif
        <label class="sr-only" for="search">Cari produk</label>
        <input type="search" id="search" name="q" value="{{ $q }}" placeholder="Cari produk..." autocomplete="off" maxlength="60">
      </form>
    </div>
    <div class="grid">
      @foreach($products as $product)
        @include('partials.product-card', ['product' => $product])
      @endforeach
    </div>
    @if($products->isEmpty())
      <p class="empty">Produk tidak ditemukan. Coba kata kunci atau kategori lain.</p>
    @endif
    <p class="note">Harga dapat berubah sewaktu-waktu. Konfirmasi harga & ketersediaan via WhatsApp.</p>
  </div>
</section>

@endsection


