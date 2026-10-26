<article class="card">
  <a class="card-img skeleton" href="{{ route('products.show', $product->slug) }}" aria-label="Lihat detail {{ $product->name }}">
    @if($product->image_url)
      <img src="{{ $product->image_url }}" alt="{{ $product->name }} — Strawberry Alfatih" loading="lazy" data-fallback>
    @else
      <span class="ph">🍓</span>
    @endif
  </a>
  <div class="card-body">
    <span class="tag">{{ $product->category }}</span>
    <h3><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
    <div class="price">{{ $product->formatted_price }}</div>
    <a class="btn btn-primary btn-block" target="_blank" rel="noopener" href="{{ $product->whatsappUrl() }}">Pesan</a>
  </div>
</article>
