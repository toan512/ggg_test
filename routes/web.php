<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BackendController;
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

Route::get('/welcome', function () {
    return view('welcome');
});

// froent route
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/detail/{id}', [FrontendController::class, 'detail'])->name('detail');
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
// ajax search
Route::post('/get_product', [FrontendController::class, 'get_product']);
// ajax add cart
Route::get('/add_cart/{id}', [FrontendController::class, 'add_cart']);

// backend route
Route::get('/backend', [BackendController::class, 'fee_manager'])->name('backend.fee_manager');
// Route::get('/fee_detail/{id}/remove', [BackendController::class, 'fee_remove']);
Route::get('/fee_detail/{id}', [BackendController::class, 'fee_detail'])->name('backend.fee_detail');
Route::post('/fee_detail/{id}', [BackendController::class, 'fee_update_process']);
Route::get('/fee_create', [BackendController::class, 'fee_create'])->name('backend.fee_create');
Route::post('/fee_create', [BackendController::class, 'fee_create_process']);

Route::get('/attribute', [BackendController::class, 'attribute_manager'])->name('backend.attribute_manager');
Route::get('/attribute/{id}/remove', [BackendController::class, 'attribute_remove']);
Route::get('/attribute_create', [BackendController::class, 'attribute_create'])->name('backend.attribute_create');
Route::post('/attribute_create', [BackendController::class, 'attribute_create_process']);
Route::get('/attribute_detail/{id}', [BackendController::class, 'attribute_detail'])->name('backend.attribute_detail');
Route::post('/attribute_detail/{id}', [BackendController::class, 'attribute_update_process']);
