<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Models\Archive;
use App\Models\Gallery;
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
// Change the values to false in case the feature is not needed
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
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::get('/g/create', [GalleryController::class, 'create'])->name('galleries.create');
    Route::post('/g/store', [GalleryController::class, 'store'])->name('galleries.store');
    Route::get('/g/{gallery}/edit', [GalleryController::class, 'edit'])->name('galleries.edit');
    Route::put('/g/{gallery}/edit', [GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/g/{gallery}/delete', [GalleryController::class, 'destroy'])->name('galleries.delete');

    Route::get('/uploads/manager', [UploadController::class, 'index'])->name('uploads.index');
    Route::get('/uploads/archives', [UploadController::class, 'archivesManager'])->name('uploads.archives');
    Route::get('/uploads/galleries', [UploadController::class, 'galleriesManager'])->name('uploads.galleries');

    Route::get('/a/{archive}/edit', [ArchiveController::class, 'edit'])->name('archives.edit');
    Route::put('/a/{archive}/edit', [ArchiveController::class, 'update'])->name('archives.update');
    Route::delete('/a/{archive}/delete', [ArchiveController::class, 'destroy'])->name('archives.delete');
    Route::get('/a/create', [ArchiveController::class, 'create'])->name('archives.create');
    Route::post('/a/store', [ArchiveController::class, 'store'])->name('archives.store');
    Route::post('/a/stores', [ArchiveController::class, 'stores'])->name('archives.stores');
    Route::get('/a/{archive}/process', [ArchiveController::class, 'process'])->name('archives.process');
});

// Globally Accessible route
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
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


