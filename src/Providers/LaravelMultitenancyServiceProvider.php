<?php

namespace JuniorFontenele\LaravelMultitenancy\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class LaravelMultitenancyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/multitenancy.php',
            'multitenancy'
        );

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/multitenancy.php' => config_path('multitenancy.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'migrations');

        Blueprint::macro('tenant', function () {
            $this->foreignId(config('multitenancy.tenant_foreign_key'))
                ->nullable()
                ->constrained(config('multitenancy.tenants_table_name'))
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }
}
