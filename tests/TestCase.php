<?php

namespace JuniorFontenele\LaravelMultitenancy\Tests;

use Illuminate\Config\Repository;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Illuminate\Support\Facades\Artisan;
use JuniorFontenele\LaravelMultitenancy\Models\Tenant;
use JuniorFontenele\LaravelMultitenancy\Models\TenantHost;
use JuniorFontenele\LaravelMultitenancy\Tests\Models\User;

abstract class TestCase extends LaravelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->defineEnvironment($this->app);

        $this->setUpDatabase($this->app);

        $this->runMigrations($this->app);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function generateRandomKey($app)
    {
        return 'base64:'.base64_encode(
            Encrypter::generateKey($app['config']['app.cipher'])
        );
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function defineEnvironment($app)
    {
        // Setup environment, like app configuration
        tap($app['config'], function (Repository $config) use ($app) {
            $config->set('app.key', $this->generateRandomKey($app));
            $config->set('app.timezone', 'UTC');
            $config->set('app.locale', 'en');
            $config->set('app.fallback_locale', 'en');

            $config->set('database.default', 'sqlite');
            $config->set('database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        });

        $app->bind('App\Models\User', User::class);
    }

    /**
     * Set up the database.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function setUpDatabase($app)
    {
        $schema = $app['db']->connection()->getSchemaBuilder();

        // Create tables

        $schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Run migrations.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function runMigrations($app)
    {
        Artisan::call('migrate:fresh');
    }

    protected function getLaravelVersion()
    {
        return (float) app()->version();
    }

    protected function createTenant(): Tenant
    {
        return Tenant::create([
            'name' => fake()->name,
        ]);
    }

    protected function createUser(): User
    {
        return User::create([
            'email' => fake()->email,
        ]);
    }

    protected function createHost(Tenant $tenant): TenantHost
    {
        return $tenant->hosts()->create([
            'host' => fake()->domainName(),
        ]);
    }
}
