<?php

namespace zedsh\zadmin;

use Illuminate\Support\ServiceProvider;
use zedsh\zadmin\Commands\ZAdminCommand;

class zadminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/zadmin'),
            ], 'views');

            $this->publishes([
                __DIR__.'/assets/admin_assets' => public_path('admin_assets'),
            ], 'public');

        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'zadmin');
    }

    public function register()
    {
    }
}
