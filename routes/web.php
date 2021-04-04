<?php

use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TestController;
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

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

// home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// help route
Route::get('/help', [HelpController::class, 'index'])->name('help');

// Search route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Test Route for View, Backend logic and etc
Route::get('/test', [TestController::class, 'index'])->name('test');
