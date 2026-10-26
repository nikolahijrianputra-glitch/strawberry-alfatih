
@extends('layouts.admin')

@php($editing = $product->exists)

@section('title', $editing ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<style>
    .sa-product-form {
        --sa-wine: #702b3b;
        --sa-wine-dark: #51202d;
        --sa-cream: #faf6f0;
        --sa-gold: #c6a36a;
        max-width: 1080px;
        margin: 0 auto;
        color: #382b2b;
    }

    .sa-product-form * {
        box-sizing: border-box;
    }

    .sa-form-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 26px;
    }

    .sa-form-heading h1 {
        margin: 0 0 7px;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 750;
        letter-spacing: -0.7px;
    }

    .sa-form-heading p {
        margin: 0;
        color: #897b78;
        font-size: 14px;
    }

    .sa-back-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        border: 1px solid #eadfd8;
        border-radius: 11px;
        background: white;
        color: var(--sa-wine);
        text-decoration: none;
        font-size: 13px;
        font-weight: 650;
        white-space: nowrap;
    }

    .sa-back-link:hover {
        background: var(--sa-cream);
    }

    .sa-form-banner {
        padding: 22px 25px;
        margin-bottom: 22px;
        border-radius: 16px;
        color: white;
        background: linear-gradient(115deg, #51202d, #843b4c);
        position: relative;
        overflow: hidden;
    }

    .sa-form-banner::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 50%;
        right: -35px;
        top: -75px;
        box-shadow: 0 0 0 22px rgba(255,255,255,.035),
                    0 0 0 45px rgba(255,255,255,.025);
        pointer-events: none;
    }

    .sa-form-banner strong {
        display: block;
        margin-bottom: 7px;
        font-size: 18px;
    }

    .sa-form-banner p {
        margin: 0;
        max-width: 620px;
        color: #f1dfe1;
        font-size: 13px;
        line-height: 1.7;
    }

    .sa-form-error {
        margin-bottom: 20px;
        padding: 16px 20px;
        border: 1px solid #efc5c5;
        border-radius: 12px;
        background: #fff3f2;
        color: #922e35;
    }

    .sa-form-error ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .sa-form-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(250px, .9fr);
        align-items: start;
        gap: 22px;
    }

    .sa-form-card {
        min-width: 0;
        padding: 25px;
        border: 1px solid #eee4dc;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(73, 39, 37, .035);
    }

    .sa-form-card + .sa-form-card {
        margin-top: 20px;
    }

    .sa-form-card-title {
        margin: 0 0 5px;
        font-size: 16px;
        font-weight: 750;
    }

    .sa-form-card-subtitle {
        margin: 0 0 23px;
        color: #958782;
        font-size: 12px;
        line-height: 1.6;
    }

    .sa-field {
        display: block;
        margin-bottom: 21px;
        color: #493737;
        font-size: 13px;
        font-weight: 650;
    }

    .sa-field:last-child {
        margin-bottom: 0;
    }

    .sa-field > span {
        display: block;
        margin-bottom: 9px;
    }

    .sa-field .sa-required {
        color: #a44754;
    }

    .sa-field input:not([type="checkbox"]):not([type="file"]),
    .sa-field select,
    .sa-field textarea {
        display: block;
        width: 100%;
        min-width: 0;
        padding: 12px 14px;
        border: 1px solid #e7dcd5;
        border-radius: 10px;
        outline: none;
        background: #fffdfa;
        color: #382b2b;
        font: inherit;
        font-size: 13px;
        font-weight: 400;
        transition: border-color .2s, box-shadow .2s;
    }

    .sa-field textarea {
        min-height: 130px;
        resize: vertical;
        line-height: 1.7;
    }

    .sa-field input:focus,
    .sa-field select:focus,
    .sa-field textarea:focus {
        border-color: var(--sa-wine);
        box-shadow: 0 0 0 3px rgba(112,43,59,.09);
    }

    .sa-field input::placeholder,
    .sa-field textarea::placeholder {
        color: #b5a9a3;
    }

    .sa-field small {
        display: block;
        margin-top: 8px;
        color: #958782;
        font-size: 11px;
        line-height: 1.65;
        font-weight: 400;
    }

    .sa-field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .sa-image-upload {
        display: block;
        padding: 17px;
        border: 1px dashed #d8c4b9;
        border-radius: 12px;
        background: #fdfaf7;
    }

    .sa-image-upload input[type="file"] {
        width: 100%;
        max-width: 100%;
        color: #766661;
        font-size: 12px;
        font-weight: 400;
    }

    .sa-image-preview {
        display: none;
        width: 100%;
        max-height: 260px;
        margin-top: 15px;
        border: 1px solid #eee4dc;
        border-radius: 12px;
        object-fit: contain;
        background: #faf7f3;
    }

    .sa-image-preview.is-visible {
        display: block;
    }

    .sa-no-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 155px;
        margin-bottom: 14px;
        border: 1px dashed #dfd2ca;
        border-radius: 12px;
        color: #9b8980;
        background: #fdfaf7;
        text-align: center;
        font-size: 12px;
    }

    .sa-no-image .sa-camera {
        font-size: 29px;
    }

    .sa-status-option {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 15px;
        border: 1px solid #eadfd8;
        border-radius: 12px;
        background: #fdfaf7;
        cursor: pointer;
    }

    .sa-status-option input {
        width: 17px;
        height: 17px;
        margin: 2px 0 0;
        accent-color: var(--sa-wine);
        flex-shrink: 0;
    }

    .sa-status-option strong {
        display: block;
        margin-bottom: 5px;
        font-size: 13px;
    }

    .sa-status-option small {
        display: block;
        color: #958782;
        font-size: 11px;
        line-height: 1.6;
        font-weight: 400;
    }

    .sa-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 22px;
        margin-top: 22px;
        border-top: 1px solid #f0e8e2;
    }

    .sa-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        min-height: 44px;
        padding: 12px 19px;
        border: 1px solid transparent;
        border-radius: 10px;
        text-decoration: none;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    .sa-btn-primary {
        background: var(--sa-wine);
        color: white;
    }

    .sa-btn-primary:hover {
        background: var(--sa-wine-dark);
        transform: translateY(-1px);
    }

    .sa-btn-secondary {
        background: white;
        border-color: #e7dcd5;
        color: #725c56;
    }

    .sa-btn-secondary:hover {
        background: var(--sa-cream);
    }

    .sa-form-note {
        margin: 13px 0 0;
        color: #9b8c84;
        font-size: 11px;
        line-height: 1.7;
        text-align: right;
    }

    @media (max-width: 760px) {
        .sa-form-layout {
            grid-template-columns: minmax(0, 1fr);
            gap: 16px;
        }

        .sa-form-heading {
            align-items: flex-start;
        }

        .sa-form-heading p {
            max-width: 240px;
            line-height: 1.6;
        }

        .sa-form-card {
            padding: 19px;
        }

        .sa-form-banner {
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .sa-form-heading {
            flex-direction: column;
        }

        .sa-form-heading h1 {
            font-size: 25px;
        }

        .sa-field-row {
            grid-template-columns: minmax(0, 1fr);
            gap: 0;
        }

        .sa-form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .sa-form-actions .sa-btn {
            width: 100%;
        }

        .sa-form-note {
            text-align: left;
        }
    }
.sa-product-form,
.sa-product-form input,
.sa-product-form textarea,
.sa-product-form select,
.sa-product-form button,
.sa-product-form label,
.sa-product-form h1,
.sa-product-form h2,
.sa-product-form p,
.sa-product-form span,
.sa-product-form a {
    font-family: Arial, Helvetica, sans-serif !important;
}
</style>

<div class="sa-product-form">
    <div class="sa-form-heading">
        <div>
            <h1>{{ $editing ? 'Edit Produk' : 'Tambah Produk' }}</h1>
            <p>
                {{ $editing
                    ? 'Perbarui informasi produk Strawberry Alfatih.'
                    : 'Lengkapi informasi produk untuk katalog Strawberry Alfatih.' }}
            </p>
        </div>

        <a class="sa-back-link" href="{{ route('admin.products.index') }}">
            &larr; Kembali ke Produk
        </a>
    </div>

    <div class="sa-form-banner">
        <strong>{{ $editing ? 'Perbarui produk pilihanmu' : 'Tambahkan produk baru' }}</strong>
        <p>
            Gunakan foto yang jelas dan informasi yang akurat agar pelanggan
            lebih mudah mengenali produk Strawberry Alfatih.
        </p>
    </div>

    @if($errors->any())
        <div class="sa-form-error" role="alert">
            <b>Periksa kembali isian berikut:</b>
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ $editing
            ? route('admin.products.update', $product)
            : route('admin.products.store') }}"
    >
        @csrf
        @if($editing)
            @method('PUT')
        @endif

        <div class="sa-form-layout">
            <div>
                <section class="sa-form-card">
                    <h2 class="sa-form-card-title">Informasi Produk</h2>
                    <p class="sa-form-card-subtitle">
                        Masukkan detail utama produk yang akan ditampilkan.
                    </p>

                    <label class="sa-field">
                        <span>Nama Produk <span class="sa-required">*</span></span>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $product->name) }}"
                            placeholder="Contoh: Strawberry Cake"
                            required
                            maxlength="120"
                        >
                    </label>

                    <div class="sa-field-row">
                        <label class="sa-field">
                            <span>Kategori <span class="sa-required">*</span></span>
                            <select name="category" required>
                                <option value="">Pilih kategori</option>
                                @foreach(config('store.categories') as $c)
                                    <option
                                        value="{{ $c }}"
                                        @selected(old('category', $product->category) === $c)
                                    >{{ $c }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="sa-field">
                            <span>Harga (Rupiah) <span class="sa-required">*</span></span>
                            <input
                                type="number"
                                name="price"
                                inputmode="numeric"
                                min="0"
                                step="1"
                                value="{{ old('price', $product->price) }}"
                                placeholder="Contoh: 110000"
                                required
                            >
                            <small>Masukkan angka tanpa titik atau simbol Rp.</small>
                        </label>
                    </div>

                    <label class="sa-field">
                        <span>Deskripsi Produk</span>
                        <textarea
                            name="description"
                            rows="5"
                            maxlength="2000"
                            placeholder="Ceritakan rasa, ukuran, bahan, atau keistimewaan produk..."
                        >{{ old('description', $product->description) }}</textarea>
                        <small>Maksimal 2.000 karakter. Bagian ini boleh dikosongkan.</small>
                    </label>
                </section>
            </div>

            <div>
                <section class="sa-form-card">
                    <h2 class="sa-form-card-title">Foto Produk</h2>
                    <p class="sa-form-card-subtitle">
                        Gunakan foto produk yang terang dan mudah dilihat.
                    </p>

                    @if($editing && $product->image_url)
                        <img
                            id="saImagePreview"
                            class="sa-image-preview is-visible"
                            src="{{ $product->image_url }}"
                            alt="Foto produk saat ini: {{ $product->name }}"
                        >
                    @else
                        <div class="sa-no-image" id="saEmptyPreview">
                            <span class="sa-camera" aria-hidden="true">&#128247;</span>
                            <span>Preview foto akan muncul di sini</span>
                        </div>
                        <img
                            id="saImagePreview"
                            class="sa-image-preview"
                            alt="Preview foto produk"
                        >
                    @endif

                    <label class="sa-field">
                        <span>
                            {{ $editing ? 'Ganti Foto Produk' : 'Upload Foto Produk' }}
                            @if(!$editing)
                                <span class="sa-required">*</span>
                            @endif
                        </span>

                        <div class="sa-image-upload">
                            <input
                                type="file"
                                id="saImageInput"
                                name="image"
                                accept="image/jpeg,image/png,image/webp"
                                {{ $editing ? '' : 'required' }}
                            >
                            <small>
                                Format JPG, PNG, atau WebP. Maksimal 4 MB.
                                {{ $editing ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}
                            </small>
                        </div>
                    </label>
                </section>

                <section class="sa-form-card">
                    <h2 class="sa-form-card-title">Publikasi</h2>
                    <p class="sa-form-card-subtitle">
                        Atur apakah produk tampil di website pelanggan.
                    </p>

                    <label class="sa-status-option">
                        <input
                            type="checkbox"
                            name="is_published"
                            value="1"
                            @checked(old('is_published', $product->is_published))
                        >
                        <span>
                            <strong>Tayangkan di website</strong>
                            <small>
                                Aktifkan untuk menampilkan produk di katalog publik.
                                Matikan untuk menyimpan produk tanpa menayangkannya.
                            </small>
                        </span>
                    </label>
                </section>
            </div>
        </div>

        <div class="sa-form-actions">
            <a
                class="sa-btn sa-btn-secondary"
                href="{{ route('admin.products.index') }}"
            >Batal</a>

            <button class="sa-btn sa-btn-primary" type="submit">
                {{ $editing ? 'Simpan Perubahan' : 'Simpan Produk' }} &rarr;
            </button>
        </div>

        <p class="sa-form-note">
            Pastikan informasi produk sudah benar sebelum menyimpan.
        </p>
    </form>
</div>

<script>
    (function () {
        const input = document.getElementById('saImageInput');
        const preview = document.getElementById('saImagePreview');
        const emptyPreview = document.getElementById('saEmptyPreview');

        if (!input || !preview) return;

        let currentObjectUrl = null;

        input.addEventListener('change', function () {
            const file = input.files && input.files[0];

            if (!file) return;

            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                input.value = '';
                alert('Pilih foto berformat JPG, PNG, atau WebP.');
                return;
            }

            if (file.size > 4 * 1024 * 1024) {
                input.value = '';
                alert('Ukuran foto maksimal 4 MB.');
                return;
            }

            if (currentObjectUrl) {
                URL.revokeObjectURL(currentObjectUrl);
            }

            currentObjectUrl = URL.createObjectURL(file);
            preview.src = currentObjectUrl;
            preview.classList.add('is-visible');

            if (emptyPreview) {
                emptyPreview.style.display = 'none';
            }
        });
    })();
</script>
@endsection

