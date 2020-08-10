<?php

namespace Zedsh\ZAdmin;

use Illuminate\Support\ServiceProvider;
use Zedsh\ZAdmin\Commands\ZAdminCommand;

class ZAdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/ZAdmin'),
            ], 'views');

            $this->publishes([
                __DIR__.'/assets/admin_assets' => public_path('admin_assets'),
            ], 'public');

            $this->commands([
                ZAdminCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ZAdmin');
    }

    public function register()
    {
    }
}
