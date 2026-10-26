<article class="card">
  <div class="card-img skeleton">
    @if($product->image_url)
      <img src="{{ $product->image_url }}" alt="{{ $product->name }} â€” Strawberry Alfatih" loading="lazy" data-fallback>
    @else
      <span class="ph">ðŸ“</span>
    @endif
  </div>
  <div class="card-body">
    <span class="tag">{{ $product->category }}</span>
    <h3>{{ $product->name }}</h3>
    <div class="price">{{ $product->formatted_price }}</div>
    <a class="btn btn-primary btn-block" target="_blank" rel="noopener" href="{{ $product->whatsappUrl() }}">Pesan</a>
  </div>
</article>
