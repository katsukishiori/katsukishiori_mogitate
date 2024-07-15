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
Route::get('/products/{product_id}', [ProductController::class, 'index']);
Route::post('/products/{product_id}/update', [ProductController::class, 'update']);
Route::post('/products/register', [ProductController::class, 'register']);
Route::post('/products/search', [ProductController::class, 'search']);
Route::post('/products/{product_id}/delete', [ProductController::class, 'delete']);