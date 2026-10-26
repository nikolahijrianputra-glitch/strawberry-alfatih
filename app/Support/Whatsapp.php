<?php

namespace App\Support;

class Whatsapp
{
    public static function number(): string
    {
        return preg_replace('/\D+/', '', (string) config('store.whatsapp'));
    }

    /** Nomor untuk tampilan, contoh 0853-7474-8715. */
    public static function display(): string
    {
        $n = preg_replace('/^62/', '0', self::number());

        return preg_replace('/^(\d{4})(\d{4})(\d+)$/', '$1-$2-$3', $n) ?? $n;
    }

    public static function url(string $message): string
    {
        return 'https://wa.me/'.self::number().'?text='.rawurlencode($message);
    }
}
