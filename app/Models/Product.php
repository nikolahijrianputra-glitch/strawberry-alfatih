<?php

namespace App\Models;

use App\Support\Whatsapp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'price', 'description', 'image_path', 'is_published'];

    protected function casts(): array
    {
        return ['price' => 'integer', 'is_published' => 'boolean'];
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true);
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $q;
        }
        $like = '%'.addcslashes($term, '%_\\').'%';

        return $q->where('name', 'like', $like);
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp'.number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('uploads/'.$this->image_path) : null;
    }

    public function whatsappUrl(): string
    {
        return Whatsapp::url("Halo Strawberry Alfatih, saya ingin memesan {$this->name} ({$this->formatted_price}). Apakah masih tersedia?");
    }
}
