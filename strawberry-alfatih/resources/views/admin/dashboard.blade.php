@extends('layouts.admin')
@section('title', 'Ringkasan')
@section('content')
<div class="head"><h1>Ringkasan</h1><a class="btn" href="{{ route('admin.products.create') }}">+ Tambah produk</a></div>
<div class="stats">
  <div class="stat"><span>Total produk</span><b>{{ $stats['total'] }}</b></div>
  <div class="stat"><span>Tayang</span><b>{{ $stats['published'] }}</b></div>
  <div class="stat"><span>Draft (disembunyikan)</span><b>{{ $stats['draft'] }}</b></div>
</div>
<div class="two">
  <section class="panel"><h2>Per kategori</h2>
    <table>@foreach(config('store.categories') as $c)<tr><td>{{ $c }}</td><td class="r">{{ $perCategory[$c] ?? 0 }}</td></tr>@endforeach</table>
  </section>
  <section class="panel"><h2>Terakhir diubah</h2>
    <table>@forelse($latest as $p)<tr><td><a href="{{ route('admin.products.edit', $p) }}">{{ $p->name }}</a></td><td class="r">{{ $p->updated_at->format('d M Y') }}</td></tr>@empty<tr><td>Belum ada produk.</td></tr>@endforelse</table>
  </section>
</div>
@endsection
