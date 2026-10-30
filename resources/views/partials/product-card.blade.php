<article class="card">
    <div class="card-img skeleton">
        @if($product->image_url)
            <img
                src="{{ $product->image_url }}"
                alt="{{ $product->name }}"
                loading="lazy"
            >
        @else
            <div class="ph" aria-label="Gambar tidak tersedia">🍓</div>
        @endif
    </div>

    <div class="card-body">
        <h3>{{ $product->name }}</h3>

        <div class="product-card-bottom">
            <span class="price">{{ $product->formatted_price }}</span>
            <a
                class="product-add"
                target="_blank"
                rel="noopener"
                href="{{ $product->whatsappUrl() }}"
                aria-label="Pesan {{ $product->name }}"
            >+</a>
        </div>
    </div>
</article>
