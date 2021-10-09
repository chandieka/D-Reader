<?php

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

// web authentication default routes
Auth::routes([
    'login' => true,    // Login Routes...
    'logout' => true,   // Logout Routes...
    'register' => true, // Registration Routes...
    'reset' => true,   // Password Reset Routes...
    'confirm' => true, // Password Confirmation Routes...
    'verify' => true,  // Email Verification Routes...
]);

// Route that require Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::get('/galleries/create', [GalleryController::class, 'create'])->name('galleries.create');

    Route::post('/galleries', [GalleryController::class, 'store'])->name('galleries.store');

    Route::get('/uploads/manager', [UploadController::class, 'index'])->name('uploads.index');

    Route::get('/uploads/archives', [UploadController::class, 'archivesManager'])->name('uploads.archives');

    Route::get('/uploads/galleries', [UploadController::class, 'galleriesManager'])->name('uploads.galleries');

});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/help', [HomeController::class, 'help'])->name('help');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/g/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');

Route::get('/g/{gallery}/{page:page_number}', [GalleryController::class, 'reader'])->name('galleries.reader');

/**
 * Route for Testing
 *
 * comment and uncomment when needed.
 */
require __DIR__.'/test.php';

