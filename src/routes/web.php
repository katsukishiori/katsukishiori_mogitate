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

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/register', [ProductController::class, 'show']);
Route::get('/products/{product_id}', [ProductController::class, 'detail'])->name('products.show');
Route::post('/products/register', [ProductController::class, 'register'])->name('products.register');
Route::put('/products/{product_id}/update', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::delete('/products/{product_id}/delete', [ProductController::class, 'destroy'])->name('products.delete');
