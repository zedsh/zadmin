<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArtistController;

Route::prefix('/admin')->name('admin.')->middleware(['auth'])->group(function() {

    Route::prefix('/artist')->name('artist.')->group(function() {
        Route::get('/list', [ArtistController::class, 'list'])->name('list');
        Route::get('/add', [ArtistController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [ArtistController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [ArtistController::class, 'delete'])->name('delete');
        Route::post('/save', [ArtistController::class, 'save'])->name('save');
    });

});
