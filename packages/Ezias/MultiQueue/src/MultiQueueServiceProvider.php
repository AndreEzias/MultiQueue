<?php

namespace Ezias\MultiQueue;

use Illuminate\Support\ServiceProvider;

class MultiQueueServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ezias');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ezias');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/multiqueue.php', 'multiqueue');

        // Register the service the package provides.
        $this->app->singleton('multiqueue', function ($app) {
            return new MultiQueue;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['multiqueue'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/multiqueue.php' => config_path('multiqueue.php'),
        ], 'multiqueue.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ezias'),
        ], 'multiqueue.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ezias'),
        ], 'multiqueue.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ezias'),
        ], 'multiqueue.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
