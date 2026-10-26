@extends('layouts.app')
@section('title', $product->name.' — Strawberry Alfatih')
@section('content')
<section class="section detail">
  <div class="container detail-grid">
    <div class="detail-img">
      @if($product->image_url)<img src="{{ $product->image_url }}" alt="{{ $product->name }} — Strawberry Alfatih" data-fallback>@else<span class="ph">🍓</span>@endif
    </div>
    <div>
      <a class="back" href="{{ route('home', ['kategori' => $product->category]) }}#katalog">← {{ $product->category }}</a>
      <h1>{{ $product->name }}</h1>
      <div class="price big">{{ $product->formatted_price }}</div>
      @if($product->description)<p class="desc">{!! nl2br(e($product->description)) !!}</p>@endif
      <p class="note-l">Harga dapat berubah. Konfirmasi ketersediaan via WhatsApp.</p>
      <a class="btn btn-primary" target="_blank" rel="noopener" href="{{ $product->whatsappUrl() }}">Pesan via WhatsApp</a>
    </div>
  </div>
</section>
@endsection
