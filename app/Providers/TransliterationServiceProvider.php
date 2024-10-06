<?php

namespace App\Providers;

use App\Http\Services\RussianToEnglishTransliterator;
use Illuminate\Support\ServiceProvider;

class TransliterationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RussianToEnglishTransliterator::class, function ($app) {
            return new RussianToEnglishTransliterator();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
