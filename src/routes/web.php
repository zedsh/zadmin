<?php


Route::group(['middleware' => ['web']], function () {
    Route::get('login', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'login']);
    Route::get('registration', [\zedsh\zadmin\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('registration');
    Route::post('registration', [\zedsh\zadmin\Controllers\Auth\RegisterController::class,'register']);
    Route::post('logout', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::prefix('/admin')->middleware(['auth', 'http.cache.drop'])->group(function () {
        Route::get('/', function () {
            return redirect(route('user.index'));
        })->name('admin');

    });
});



