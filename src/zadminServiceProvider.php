<?php

namespace zedsh\zadmin;

use Illuminate\Support\ServiceProvider;
use MongoDB\Driver\Command;
use zedsh\zadmin\Builder\Builders\AdminBuilder;
use zedsh\zadmin\Builder\Builders\BuilderInterface;
use zedsh\zadmin\Builder\Workers\PageInterface;
use zedsh\zadmin\Builder\Workers\PageWorker;
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
                __DIR__.'/../assets/admin_assets' => public_path('admin_assets'),
            ], 'public');

            $this->commands([
                ZAdminCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'zadmin');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {
    }

    public function provides()
    {
        return [ZAdminCommand::class];
    }
}
