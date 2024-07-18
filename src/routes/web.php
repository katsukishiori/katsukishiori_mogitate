<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeasonController;

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
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/register', [ProductController::class, 'show']);
Route::get('/products/{id}', [ProductController::class, 'detail'])->name('products.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/products/register', [ProductController::class, 'register'])->name('products.register');
