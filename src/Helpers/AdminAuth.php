<?php

namespace zedsh\zadmin\Helpers;

use Illuminate\Support\Facades\Route;


class AdminAuth
{
    public static $app_routes = array();
    public static $authRoutesIsPublished = false;


    public static function routes(array $options = [], string $prefix, string $name_prefix)
    {
        Route::prefix($prefix)->name($name_prefix . '.')->middleware(['web'])->group(function () use ($options) {
            if ($options['login'] ?? true) {
                Route::get('login',
                    [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
                Route::post('login', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'login']);
            }
            if ($options['registration'] ?? true) {
                Route::get('registration', [
                    \zedsh\zadmin\Controllers\Auth\RegisterController::class,
                    'showRegistrationForm'
                ])->name('registration');
                Route::post('registration', [\zedsh\zadmin\Controllers\Auth\RegisterController::class, 'register']);
            }
            if ($options['logout'] ?? true) {
                Route::post('logout',
                    [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
            }
        });
    }

    public static function checkExistAuthRoutesInApp()
    {
        foreach (Route::getRoutes() as $route) {
            self::$app_routes[] = $route->uri;
        }

        if (in_array('admin/login', self::$app_routes) &&
            in_array('admin/registration', self::$app_routes) &&
            in_array('admin/logout', self::$app_routes)) {
            self::$authRoutesIsPublished = true;
        }

        return self::$authRoutesIsPublished;
    }
}



