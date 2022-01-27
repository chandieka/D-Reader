<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/**
 * Route that was intended for testing or researching can be put here
 *
 */


Route::get('/test', [TestController::class, 'index'])->name('test.index');
Route::post('/test', [TestController::class, 'fileUpload'])->name('test.upload');
Route::get('/test/img', [TestController::class, 'fileStorageTest']);
Route::get('/test/galleries/{gallery}/{page:page_number}', [TestController::class, 'show']);
Route::get('/test/resize', [TestController::class, 'resizeImageTest']);
Route::get('/test/job', [TestController::class, 'testJob']);
Route::get('/test/delete', [TestController::class, 'TestDeleteGallery']);

// testing ENV adjustable route
if (env('OPTIONS_1', true)) {
    Route::get('/exception', [TestController::class, 'testException']);
}
