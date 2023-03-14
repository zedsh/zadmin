<?php

namespace zedsh\zadmin;

use Illuminate\Support\ServiceProvider;
use zedsh\zadmin\Commands\ZAdminCreateController;
use zedsh\zadmin\Commands\ZAdminInstall;

class zadminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/zadmin'),
            ], 'views');

            $this->publishes([
                __DIR__ . '/../assets/admin_assets' => public_path('admin_assets'),
            ], 'public');

            $this->commands([
                ZAdminInstall::class,
                ZAdminCreateController::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'zadmin');
//        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {
    }

    public function provides()
    {
        return [
            ZAdminInstall::class,
            ZAdminCreateController::class,
        ];
    }
}
