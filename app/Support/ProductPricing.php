<?php
namespace App\Support;

class ProductPricing
{
    /** Works for both database Products and the existing public fallback objects. */
    public static function label(object $product): string
    {
        if ($product->price === null || (float) $product->price <= 0) {
            return 'Harga menyesuaikan kebutuhan';
        }
        $startingAt = $product->price_is_starting_at ?? true;
        return ($startingAt ? 'Mulai dari ' : '').'Rp'.number_format((float) $product->price, 0, ',', '.');
    }
}
