<?php

use App\Http\Controllers\BlogController;
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


Route::prefix('blog')->group(function () {
    Route::get('', [BlogController::class, 'index'])->name('blogs.index');
    Route::post('store', [BlogController::class, 'store'])->name('blogs.store');
});
