<?php

namespace zedsh\zadmin;

use Illuminate\Support\ServiceProvider;
use zedsh\zadmin\Builder\Builders\AdminBuilder;
use zedsh\zadmin\Builder\Builders\BuilderInterface;
use zedsh\zadmin\Builder\Workers\PageInterface;
use zedsh\zadmin\Builder\Workers\PageWorker;

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
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'zadmin');
        $this->app->bind(PageInterface::class, PageWorker::class);
        $this->app->bind(BuilderInterface::class, AdminBuilder::class);
    }

    public function register()
    {
    }
}
