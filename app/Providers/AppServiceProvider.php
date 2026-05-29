<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Helper function for phone number formatting
        \Blade::directive('formatPhone', function ($expression) {
            return "<?php echo '+62' . ltrim(ltrim($expression, '+62'), '0'); ?>";
        });
    }
}
