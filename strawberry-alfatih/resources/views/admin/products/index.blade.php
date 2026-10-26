@extends('layouts.admin')
@section('title', 'Produk')
@section('content')
<div class="head"><h1>Produk</h1><a class="btn" href="{{ route('admin.products.create') }}">+ Tambah produk</a></div>
<form class="searchbar" method="GET"><input type="search" name="q" value="{{ $q }}" placeholder="Cari nama produk…" maxlength="60"><button class="btn ghost" type="submit">Cari</button></form>
<div class="table-wrap"><table class="list">
  <thead><tr><th>Foto</th><th>Nama</th><th>Kategori</th><th class="r">Harga</th><th>Status</th><th></th></tr></thead>
  <tbody>
  @forelse($products as $p)
    <tr>
      <td>@if($p->image_url)<img class="thumb" src="{{ $p->image_url }}" alt="{{ $p->name }}" loading="lazy">@endif</td>
      <td>{{ $p->name }}</td><td>{{ $p->category }}</td><td class="r">{{ $p->formatted_price }}</td>
      <td><span class="badge {{ $p->is_published ? 'on' : '' }}">{{ $p->is_published ? 'Tayang' : 'Draft' }}</span></td>
      <td class="acts">
        <a href="{{ route('admin.products.edit', $p) }}">Edit</a>
        <form method="POST" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Hapus produk &quot;{{ e($p->name) }}&quot;? Tindakan ini tidak bisa dibatalkan.')">
          @csrf @method('DELETE')<button class="link-btn danger" type="submit">Hapus</button>
        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="6">Tidak ada produk.</td></tr>
  @endforelse
  </tbody>
</table></div>
<div class="pager">@if($products->onFirstPage() === false)<a href="{{ $products->previousPageUrl() }}">← Sebelumnya</a>@endif
@if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}">Berikutnya →</a>@endif</div>
@endsection
