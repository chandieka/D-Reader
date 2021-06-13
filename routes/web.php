<?php

use App\Http\Controllers\Api\GalleryController as ApiGalleryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/test', [TestController::class, 'index'])->name('test');

Route::get('/help', [HelpController::class, 'index'])->name('help');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/galleries/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');

Route::get('/test', [ApiGalleryController::class, 'index']);

// Route that need Authentication to be used
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/uploads', [UploadController::class, 'index'])->name('uploads.index');
    Route::get('/gallerries/create', [GalleryController::class, 'create'])->name('galleries.create');
});


