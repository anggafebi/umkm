<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $settings = [];

        try {
            if (Schema::hasTable('settings')) {
                $settings = Cache::remember('site_settings', 300, fn () =>
                    Setting::query()->pluck('value', 'key')->all()
                );
            }
        } catch (\Throwable $e) {
            $settings = [];
        }

        View::share('siteSettings', $settings);
    }
}
