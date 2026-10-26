@extends('layouts.admin')
@php($editing = $product->exists)
@section('title', $editing ? 'Edit produk' : 'Tambah produk')
@section('content')
<div class="head"><h1>{{ $editing ? 'Edit produk' : 'Tambah produk' }}</h1><a class="btn ghost" href="{{ route('admin.products.index') }}">← Kembali</a></div>
@if($errors->any())<div class="flash err" role="alert"><b>Periksa kembali isian:</b><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form class="panel form" method="POST" enctype="multipart/form-data"
      action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
  @csrf @if($editing) @method('PUT') @endif
  <label>Nama produk<input name="name" value="{{ old('name', $product->name) }}" required maxlength="120"></label>
  <div class="row2">
    <label>Kategori
      <select name="category" required>
        <option value="">— pilih —</option>
        @foreach(config('store.categories') as $c)<option value="{{ $c }}" @selected(old('category', $product->category) === $c)>{{ $c }}</option>@endforeach
      </select>
    </label>
    <label>Harga (Rupiah)<input name="price" inputmode="numeric" value="{{ old('price', $product->price) }}" required placeholder="mis. 110000"></label>
  </div>
  <label>Deskripsi (opsional)<textarea name="description" rows="4" maxlength="2000">{{ old('description', $product->description) }}</textarea></label>
  <label>Foto produk {{ $editing ? '(kosongkan jika tidak diganti)' : '' }}
    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" {{ $editing ? '' : 'required' }}>
    <small>JPG, PNG, atau WebP, maksimal 4 MB. Foto akan diperkecil otomatis.</small>
  </label>
  @if($editing && $product->image_url)<img class="preview" src="{{ $product->image_url }}" alt="Foto saat ini: {{ $product->name }}">@endif
  <label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $product->is_published))> Tayangkan di website</label>
  <button class="btn" type="submit">{{ $editing ? 'Simpan perubahan' : 'Simpan produk' }}</button>
</form>
@endsection
