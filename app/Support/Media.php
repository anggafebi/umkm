<?php

namespace App\Support;

class Media
{
    public static function url(?string $path, string $fallback = 'images/placeholder.svg'): string
    {
        $path = trim((string) $path);

        if ($path !== '' && preg_match('~^https?://~i', $path)) {
            return $path;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if ($normalized !== '') {
            if (str_starts_with($normalized, 'storage/')) {
                $relative = substr($normalized, strlen('storage/'));
                if (is_file(storage_path('app/public/'.$relative))) {
                    return asset($normalized);
                }
            } elseif (is_file(public_path($normalized))) {
                return asset($normalized);
            }

            if (!str_contains($normalized, '/')) {
                foreach (['images/products','images/portfolio','images/testimonial','images/blog','images/services','images'] as $directory) {
                    $candidate = $directory.'/'.$normalized;
                    if (is_file(public_path($candidate))) {
                        return asset($candidate);
                    }
                }

                if (is_file(storage_path('app/public/uploads/'.$normalized))) {
                    return asset('storage/uploads/'.$normalized);
                }
            }
        }

        $fallback = ltrim($fallback, '/');
        return asset(is_file(public_path($fallback)) ? $fallback : 'images/placeholder.svg');
    }
}
