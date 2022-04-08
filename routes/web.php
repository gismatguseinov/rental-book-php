<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [SiteController::class, 'index'])->name('site.index');
    Route::get('/books', [SiteController::class, 'getBooks'])->name('site.books');
    Route::get('/books/{id}', [SiteController::class, 'singleBook'])->name('site.single-book');
    Route::post('/books/{id}/borrow', [SiteController::class, 'borrowBook'])->name('site.borrow-book');

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::prefix('/genres')->group(function () {
            Route::get('/', [DashboardController::class, 'genres'])->name('dashboard.genres');
            Route::get('/{id}', [GenreController::class, 'singleGenre'])->name('dashboard.single-genre');
            Route::post('/delete/{id}', [GenreController::class, 'delete'])->name('dashboard.delete-genre');
            Route::post('/edit/{id}', [GenreController::class, 'update'])->name('dashboard.update-genre');
            Route::post('/add-genre', [GenreController::class, 'addGenre'])->name('dashboard.add-genre');

        });

        Route::prefix('/books')->group(function () {
            Route::get('/', [DashboardController::class, 'books'])->name('dashboard.books');
            Route::get('/{id}', [BookController::class, 'singleBook'])->name('dashboard.single-book');
            Route::post('/add-books', [BookController::class, 'addBook'])->name('dashboard.add-book');
            Route::post('/edit/{id}', [BookController::class, 'update'])->name('dashboard.update-book');
            Route::post('/delete/{id}', [BookController::class, 'delete'])->name('dashboard.destroy-book');
        });

        Route::prefix('/borrows')->group(function () {
            Route::get('/', [DashboardController::class, 'borrow'])->name('dashboard.borrows');

        });

        Route::post('/book/{id}/accept', [BookController::class, 'accept'])->name('dashboard.accept-borrow');
    });
});
Auth::routes();


