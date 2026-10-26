<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null; // semua pengguna terdaftar adalah admin (tanpa registrasi publik)
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => preg_replace('/\D+/', '', (string) $this->input('price')),
            'is_published' => $this->boolean('is_published'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', Rule::in(config('store.categories'))],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_published' => ['boolean'],
            'image' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'file', 'image', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096', 'dimensions:max_width=8000,max_height=8000',
            ],
        ];
    }

    public function attributes(): array
    {
        return ['name' => 'nama produk', 'category' => 'kategori', 'price' => 'harga', 'description' => 'deskripsi', 'image' => 'foto'];
    }
}
