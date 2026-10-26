@extends('layouts.app')
@section('content')
<section class="hero" id="beranda">
  <span class="berry b1" aria-hidden="true">🍓</span><span class="berry b2" aria-hidden="true">🍓</span>
  <div class="container hero-grid">
    <div class="hero-text">
      <span class="eyebrow">Strawberry Alfatih · Cake & Dessert</span>
      <h1>Manis untuk Setiap Momen</h1>
      <p>Cake, cheesecake, brownies, dan shortcake dengan stroberi segar — dibuat untuk ulang tahun, kejutan, dan hari-hari yang ingin kamu rayakan.</p>
      <div class="hero-btns">
        <a href="#katalog" class="btn btn-primary">Lihat Katalog</a>
        <a href="{{ \App\Support\Whatsapp::url('Halo Strawberry Alfatih, saya ingin bertanya dan memesan kue.') }}" target="_blank" rel="noopener" class="btn btn-outline">Pesan via WhatsApp</a>
      </div>
    </div>
    <div class="hero-photo">
      <img src="{{ asset('assets/img/hero.jpg') }}" alt="Burn Cheesecake dengan topping stroberi segar" width="274" height="324" fetchpriority="high">
    </div>
  </div>
</section>

<section class="stats-luxury" aria-label="Keunggulan Strawberry Alfatih">
  <div class="container stats-grid">
    <article class="stat-card"><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6M23 11h-6"/></svg></span><strong>{{ $products->count() }}+</strong><span>Produk Pilihan</span></article>
    <article class="stat-card"><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 7h16v13H4zM8 7V4m8 3V4M4 11h16M8 15h3"/></svg></span><strong>Fresh</strong><span>Dibuat dengan Cinta</span></article>
    <article class="stat-card"><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8A8.5 8.5 0 0 1 8.7 3.9a8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/></svg></span><strong>Easy</strong><span>Pesan via WhatsApp</span></article>
  </div>
</section>

<section class="section" id="katalog">
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
             href="{{ route('home', array_filter(['kategori' => $c === 'Semua' ? null : $c, 'q' => $q ?: null])) }}#katalog">{{ $c }}</a>
        @endforeach
      </div>
      <form class="search" method="GET" action="{{ route('home') }}#katalog" role="search">
        @if($active)<input type="hidden" name="kategori" value="{{ $active }}">@endif
        <label class="sr-only" for="search">Cari produk</label>
        <input type="search" id="search" name="q" value="{{ $q }}" placeholder="Cari produk…" autocomplete="off" maxlength="60">
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

<section class="section about" id="tentang">
  <div class="container about-grid">
    <img src="{{ asset('assets/img/brand/logo-circle.jpg') }}" alt="Papan logo Strawberry Alfatih Cake & Dessert" width="280" height="297" loading="lazy">
    <div>
      <h2>Tentang Kami</h2>
      <p>Strawberry Alfatih adalah toko cake & dessert yang menyajikan cheesecake, shortcake, brownies, dan kue custom dengan sentuhan stroberi. Setiap kue dapat diberi tulisan ucapan sesuai momen spesialmu.</p>
      <p>Untuk request desain, tulisan ucapan, atau pesanan khusus, hubungi kami lewat WhatsApp.</p>
    </div>
  </div>
</section>
@endsection
