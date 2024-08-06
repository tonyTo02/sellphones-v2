<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GuestController::class, 'index'])->name('homepage');
Route::get('/cart', [GuestController::class, 'viewCart'])->name('guess.cart');
Route::post('/{id}', [GuestController::class, 'addToCart'])->name('guess.add.cart');

Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'loadLoginForm'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'checkLogin'])->name('auth.check.login');
    Route::post('/logout', [LoginController::class, 'logOut'])->name('auth.logout');
    Route::get('/register', [RegisterController::class, 'loadRegisterForm'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'registerNew'])->name('auth.register.new');
});

Route::prefix('admin')->group(function () {
    Route::get('/bill', [BillController::class, 'index'])->name('bill.index');
    Route::get('/bill/create', [BillController::class, 'create'])->name('bill.create');
    Route::post('/bill', [BillController::class, 'store'])->name('bill.store');
    Route::get('/bill/{id}/edit', [BillController::class, 'edit'])->name('bill.edit');
    Route::put('/bill/{id}', [BillController::class, 'update'])->name('bill.update');
    Route::delete('/bill/{id}', [BillController::class, 'destroy'])->name('bill.destroy');
});
Route::prefix('admin')->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});
Route::prefix('admin')->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});
Route::prefix('admin')->group(function () {
    Route::get('/manufacturer', [ManufacturerController::class, 'index'])->name('manufacturer.index');
    Route::get('/manufacturer/create', [ManufacturerController::class, 'create'])->name('manufacturer.create');
    Route::post('/manufacturer', [ManufacturerController::class, 'store'])->name('manufacturer.store');
    Route::get('/manufacturer/{id}/edit', [ManufacturerController::class, 'edit'])->name('manufacturer.edit');
    Route::put('/manufacturer/{id}', [ManufacturerController::class, 'update'])->name('manufacturer.update');
    Route::delete('/manufacturer/{id}', [ManufacturerController::class, 'destroy'])->name('manufacturer.destroy');
});
