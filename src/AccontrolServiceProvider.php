<?php

namespace Mawuekom\Accontrol;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mawuekom\Accontrol\Accontrol;
use Mawuekom\Accontrol\Commands\InstallCommand;
use Mawuekom\Accontrol\Providers\AccontrolEventServiceProvider;

class AccontrolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        require_once __DIR__.'/helpers.php';
        
        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'accontrol');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'accontrol');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this ->registerBladeExtension();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/accontrol.php' => config_path('accontrol.php'),
            ], 'config');

            // publishing the seeders
            $this->publishes([
                __DIR__.'/../database/seeders/publish' => database_path('seeders'),
            ], 'seeders');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/accontrol'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/accontrol'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/accontrol'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/accontrol.php', 'accontrol');

        $this->app->register(AccontrolEventServiceProvider::class);

        // Register the main class to use with the facade
        $this->app->singleton('accontrol', function () {
            return new Accontrol;
        });
    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    public function registerBladeExtension()
    {
        Blade::if('role', function ($expression) {
            return has_role($expression);
        });

        Blade::if('permission', function ($expression) {
            return has_permission($expression);
        });

        Blade::if('level', function ($expression) {
            return has_level($expression);
        });
    }
}
