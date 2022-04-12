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
    Route::get('/books/{id}', [SiteController::class, 'singleBook'])->where('id', '[0-9]+')->name('site.single-book');
    Route::post('/books/{id}/borrow', [SiteController::class, 'borrowBook'])->where('id', '[0-9]+')->name('site.borrow-book');
    Route::get('/my-borrows', [SiteController::class, 'myBorrowList'])->name('site.borrow-list');
    Route::get('/about-us', [SiteController::class, 'aboutUs'])->name('site.about-us');
    Route::get('/search', [SiteController::class, 'search'])->name('site.search');
    Route::get('/profile', [SiteController::class, 'profile'])->name('site.profile');

    Route::group(['prefix' => 'dashboard', 'middleware' => 'librarian'], function () {

        Route::prefix('/genres')->group(function () {
            Route::get('/', [DashboardController::class, 'genres'])->name('dashboard.genres');
            Route::get('/{id}', [GenreController::class, 'singleGenre'])->where('id', '[0-9]+')->name('dashboard.single-genre');
            Route::post('/delete/{id}', [GenreController::class, 'delete'])->where('id', '[0-9]+')->name('dashboard.delete-genre');
            Route::post('/edit/{id}', [GenreController::class, 'update'])->where('id', '[0-9]+')->name('dashboard.update-genre');
            Route::post('/add-genre', [GenreController::class, 'addGenre'])->name('dashboard.add-genre');

        });

        Route::prefix('/books')->group(function () {
            Route::get('/', [DashboardController::class, 'books'])->name('dashboard.books');
            Route::get('/{id}', [BookController::class, 'singleBook'])->where('id', '[0-9]+')->name('dashboard.single-book');
            Route::post('/add-books', [BookController::class, 'addBook'])->name('dashboard.add-book');
            Route::post('/edit/{id}', [BookController::class, 'update'])->where('id', '[0-9]+')->name('dashboard.update-book');
            Route::post('/delete/{id}', [BookController::class, 'delete'])->where('id', '[0-9]+')->name('dashboard.destroy-book');
        });

        Route::prefix('/borrows')->group(function () {
            Route::get('/', [DashboardController::class, 'borrow'])->name('dashboard.borrows');
            Route::get('/late-borrows', [DashboardController::class, 'returnAndReject'])->name('dashboard.return-reject-borrows');
            Route::post('/reject/{id}', [BookController::class, 'reject'])->where('id', '[0-9]+')->name('dashboard.reject-borrow');
            Route::post('/accept/{id}', [BookController::class, 'accept'])->where('id', '[0-9]+')->name('dashboard.accept-borrow');
            Route::post('/return/{id}', [BookController::class, 'returnBorrow'])->where('id', '[0-9]+')->name('dashboard.return-borrow');

        });


    });
});
Auth::routes();


