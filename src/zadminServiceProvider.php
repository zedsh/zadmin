<?php

namespace zedsh\zadmin;

use Illuminate\Support\ServiceProvider;
use zedsh\zadmin\Commands\ZAdminCreateController;
use zedsh\zadmin\Commands\ZAdminInstallAdminResourceController;
use zedsh\zadmin\Commands\ZAdminInstallAssets;
use zedsh\zadmin\Commands\ZAdminInstallProjectTemplate;

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
                ZAdminInstallProjectTemplate::class,
                ZAdminInstallAdminResourceController::class,
                ZAdminInstallAssets::class,
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
            ZAdminInstallProjectTemplate::class,
            ZAdminInstallAdminResourceController::class,
            ZAdminInstallAssets::class,
            ZAdminCreateController::class,
        ];
    }
}
