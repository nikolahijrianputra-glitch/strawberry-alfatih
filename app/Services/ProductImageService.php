<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Menyimpan foto produk dengan aman: isi file dibaca ulang dengan GD lalu
 * ditulis ulang sebagai JPEG baru (payload/metadata berbahaya ikut terbuang),
 * dengan nama acak. Hanya path relatif yang disimpan di database.
 */
class ProductImageService
{
    public const DIR = 'products';
    private const MAX_SIDE = 1200;

    public function store(UploadedFile $file): string
    {
        if (! function_exists('imagecreatefromstring')) {
            throw new RuntimeException('Ekstensi PHP GD belum aktif di server.');
        }

        $img = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));
        if (! $img) {
            throw new RuntimeException('File bukan gambar yang valid.');
        }

        $img = $this->fixOrientation($img, $file->getRealPath());
        $w = imagesx($img);
        $h = imagesy($img);
        $scale = min(1, self::MAX_SIDE / max($w, $h));
        $nw = max(1, (int) round($w * $scale));
        $nh = max(1, (int) round($h * $scale));

        $out = imagecreatetruecolor($nw, $nh);
        imagefill($out, 0, 0, imagecolorallocate($out, 255, 255, 255));
        imagecopyresampled($out, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);

        $dir = public_path('uploads/'.self::DIR);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $name = Str::uuid()->toString().'.jpg';
        if (! imagejpeg($out, $dir.DIRECTORY_SEPARATOR.$name, 85)) {
            throw new RuntimeException('Gagal menyimpan gambar.');
        }

        return self::DIR.'/'.$name;
    }

    public function delete(?string $path): void
    {
        if (! $path || ! str_starts_with($path, self::DIR.'/') || str_contains($path, '..')) {
            return;
        }
        $full = public_path('uploads/'.$path);
        if (is_file($full)) {
            @unlink($full);
        }
    }

    private function fixOrientation(\GdImage $img, string $file): \GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $img;
        }
        $exif = @exif_read_data($file);
        $deg = match ($exif['Orientation'] ?? 1) {
            3 => 180, 6 => -90, 8 => 90, default => 0,
        };

        return $deg ? (imagerotate($img, $deg, 0) ?: $img) : $img;
    }
}
