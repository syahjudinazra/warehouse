<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExcelsExport;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExcelController;

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

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('products')->group(function () {
    Route::get('', [App\Http\Controllers\ProductController::class, 'products'])->name('products');
    Route::post('', [App\Http\Controllers\ProductController::class, 'product_save'])->name('products.save');
    Route::delete('', [App\Http\Controllers\ProductController::class, 'product_delete'])->name('products.delete')->middleware('adminRole');
    Route::get('wip', [App\Http\Controllers\ProductController::class, 'products_wip'])->name('products.wip');
    Route::post('wip', [App\Http\Controllers\ProductController::class, 'product_wip_save'])->name('products.wip.save');
    Route::delete('wip', [App\Http\Controllers\ProductController::class, 'product_wip_delete'])->name('products.wip.delete');
    Route::post('wip/complete', [App\Http\Controllers\ProductController::class, 'product_wip_complete'])->name('products.wip.complete');
    Route::get('/check/{pcode}', [App\Http\Controllers\ProductController::class, 'product_check'])->name('products.check');
    Route::post('/stockUpdate', [App\Http\Controllers\ProductController::class, 'product_stock'])->name('products.stock');
    Route::get('/stockHistory', [App\Http\Controllers\ProductController::class, 'product_stock_history'])->name('products.stock.history');
    Route::get('categories', [App\Http\Controllers\ProductController::class, 'categories'])->name('products.categories');
    Route::post('categories', [App\Http\Controllers\ProductController::class, 'categories_save'])->name('products.categories.save')->middleware('adminRole');
    Route::delete('categories', [App\Http\Controllers\ProductController::class, 'categories_delete'])->name('products.categories.delete')->middleware('adminRole');
    Route::get('shelf', [App\Http\Controllers\ProductController::class, 'shelf'])->name('products.shelf');
    Route::post('shelf', [App\Http\Controllers\ProductController::class, 'shelf_save'])->name('products.shelf.save')->middleware('adminRole');
    Route::delete('shelf', [App\Http\Controllers\ProductController::class, 'shelf_delete'])->name('products.shelf.delete')->middleware('adminRole');
    Route::get('barcode/{code}', [App\Http\Controllers\ProductController::class, 'generateBarcode'])->name('products.barcode');
<<<<<<< HEAD
    Route::get('export_history', [App\Http\Controllers\ProductController::class, 'export_history'])->name('products.export_history');
=======

>>>>>>> main
});
    Route::get('/stock', 'ExcelController@index');
    Route::get('/stock/export_excel', [App\Http\Controllers\ExcelController::class, 'export_excel'])->name('excel.report');

Route::prefix('users')->group(function () {
    Route::get('', [App\Http\Controllers\UserController::class, 'users'])->name('users')->middleware('adminRole');
    Route::delete('', [App\Http\Controllers\UserController::class, 'user_delete'])->name('users.delete')->middleware('adminRole');
    Route::post('', [App\Http\Controllers\UserController::class, 'user_save'])->name('users.save')->middleware('adminRole');
    
});

Route::prefix('account')->group(function () {
    Route::get('', [App\Http\Controllers\UserController::class, 'myaccount'])->name('myaccount');
    Route::post('profile', [App\Http\Controllers\UserController::class, 'myaccount_update'])->name('myaccount.update');
    Route::post('password', [App\Http\Controllers\UserController::class, 'myaccount_update_password'])->name('myaccount.updatePassword');
});