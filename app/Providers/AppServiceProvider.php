<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        Paginator::useTailwind();

        if ($this->app->environment('production', 'staging')) {
            URL::forceScheme('https');
        }

        // Prevent lazy loading & catch model bugs early in local development
        Model::shouldBeStrict(! $this->app->isProduction());

        // Self-heal storage symlink if deleted or missing after git pull
        if (! file_exists(public_path('storage'))) {
            try {
                $this->app->make('files')->link(storage_path('app/public'), public_path('storage'));
            } catch (\Throwable $e) {
                // Silently ignore if symlink is restricted on the environment
            }
        }
    }
}
