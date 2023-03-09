<?php

namespace zedsh\zadmin\Helpers;

use Illuminate\Support\Facades\Route;


class AdminAuth {
    protected string $prefix;
    protected string $name_prefix;
    protected array $middlewares;
    public static function routes(array $middlewares = [], string $prefix, string $name_prefix) {
        Route::group(['middleware' => ['web']], function () use ($prefix,$name_prefix,$middlewares) {
            Route::get('login', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
            Route::post('login', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'login']);
            Route::get('registration', [\zedsh\zadmin\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('registration');
            Route::post('registration', [\zedsh\zadmin\Controllers\Auth\RegisterController::class,'register']);
            Route::post('logout', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

            Route::prefix('/'.$prefix)->middleware($middlewares)->name($name_prefix.'.')->group(function () {
                Route::get('/', function () {
                    return redirect(route('user.index'));
                });

            });
        });
    }
}

