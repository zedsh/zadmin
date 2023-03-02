<?php


Route::group(['middleware' => ['web']], function () {
    Route::get('login', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'login']);
    Route::get('registration', [\zedsh\zadmin\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('registration');
    Route::post('registration', [\zedsh\zadmin\Controllers\Auth\RegisterController::class,'register']);
    Route::post('logout', [\zedsh\zadmin\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::prefix('/admin')->middleware(['auth', 'http.cache.drop'])->group(function () {
        Route::get('/', function () {
//            return view('zadmin::pages.admin-profile.index');
            return redirect(route('user.index'));
        })->name('admin');

        Route::prefix('/menu')->name('menu.')->middleware('admin')->group(function () {
            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\MenuController::class, 'edit'])->name('edit');
            Route::get('/add', [\App\Http\Controllers\Admin\MenuController::class, 'add'])->name('add');
            Route::post('/save', [\App\Http\Controllers\Admin\MenuController::class, 'save'])->name('save');
            Route::get('/delete/{id}', [\App\Http\Controllers\Admin\MenuController::class, 'delete'])->name('delete');
            Route::get('/list', [\App\Http\Controllers\Admin\MenuController::class, 'list'])->name('list');
            Route::get('/replicate/{id}', [\App\Http\Controllers\Admin\MenuController::class, 'replicate'])->name('replicate');
            Route::get('/pages/', [\App\Http\Controllers\Admin\MenuController::class, 'pagesSelect'])->name('pages_select');
            Route::prefix('/item')->name('item.')->group(function () {
                Route::get('/edit/{menuId}/{id}', [\App\Http\Controllers\Admin\MenuItemController::class, 'edit'])->name('edit');
                Route::get('/add/{menuId}', [\App\Http\Controllers\Admin\MenuItemController::class, 'add'])->name('add');
                Route::post('/save/{menuId}', [\App\Http\Controllers\Admin\MenuItemController::class, 'save'])->name('save');
                Route::get('/delete/{menuId}/{id}', [\App\Http\Controllers\Admin\MenuItemController::class, 'delete'])->name('delete');
                Route::get('/list/{menuId}', [\App\Http\Controllers\Admin\MenuItemController::class, 'list'])->name('list');
            });
        });

        Route::get('admin_news/image_remove', [\App\Http\Controllers\Admin\NewsController::class, 'removeImage'])
            ->name('admin_news.remove_image');
        Route::resource('admin_news', \App\Http\Controllers\Admin\NewsController::class);
        Route::resource('tag', \App\Http\Controllers\Admin\TagController::class);

        Route::resource('user', \App\Http\Controllers\Admin\UserController::class);

    });
});



