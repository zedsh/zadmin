<?php

namespace zedsh\zadmin\Helpers;

use Illuminate\Support\Facades\Route;


class AdminAuth
{
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
}



