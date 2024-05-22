<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Auth::routes();

Route::middleware(['auth', 'role:superadmin|merchant'])->group(function() {

    Route::get('', [IndexController::class, 'index'])->name('index');

    Route::get('master/companies', [MasterController::class, 'companies'])->name('master.company');
    Route::get('master/categories', [MasterController::class, 'categories'])->name('master.category');
    Route::get('master/customers', [MasterController::class, 'customers'])->name('master.customer');
    Route::get('master/products', [MasterController::class, 'products'])->name('master.product');

    Route::prefix('categories')->group(function() {
        Route::get('', [CategoryController::class, 'index'])->name('category.index');
        Route::get('create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('edit/{uuid}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('update/{uuid}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('delete/{uuid}', [CategoryController::class, 'destroy'])->name('category.delete');
    });

    Route::prefix('companies')->group(function() {
        Route::get('', [CompanyController::class, 'index'])->name('company.index');
        Route::get('create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('store', [CompanyController::class, 'store'])->name('company.store');
        Route::get('edit/{uuid}', [CompanyController::class, 'edit'])->name('company.edit');
        Route::post('update/{uuid}', [CompanyController::class, 'update'])->name('company.update');
        Route::delete('delete/{uuid}', [CompanyController::class, 'destroy'])->middleware('role:superadmin')->name('company.delete');
    });
    
    Route::prefix('customers')->group(function() {
        Route::get('', [CustomerController::class, 'index'])->name('customer.index');
        Route::middleware('role:superadmin')->group(function() {
            Route::get('create', [CustomerController::class, 'create'])->name('customer.create');
            Route::post('store', [CustomerController::class, 'store'])->name('customer.store');
            Route::get('edit/{uuid}', [CustomerController::class, 'edit'])->name('customer.edit');
            Route::post('update/{uuid}', [CustomerController::class, 'update'])->name('customer.update');
            Route::delete('delete/{uuid}', [CustomerController::class, 'destroy'])->name('customer.delete');
        });
    });

    Route::prefix('orders')->group(function() {
        Route::get('', [OrderController::class, 'index'])->name('order.index');
        Route::get('create', [OrderController::class, 'create'])->name('order.create');
        Route::post('store', [OrderController::class, 'store'])->name('order.store');
        Route::get('edit/{uuid}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('update/{uuid}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('delete/{uuid}', [OrderController::class, 'destroy'])->name('order.delete');
        
        Route::get('invoice/{uuid}', [OrderController::class, 'invoice'])->name('order.invoice');
    });

    Route::prefix('products')->group(function() {
        Route::get('', [ProductController::class, 'index'])->name('product.index');
        Route::get('create', [ProductController::class, 'create'])->name('product.create');
        Route::post('store', [ProductController::class, 'store'])->name('product.store');
        Route::get('edit/{uuid}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('update/{uuid}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('delete/{uuid}', [ProductController::class, 'destroy'])->name('product.delete');
    
        Route::delete('image/delete/{uuid}', [ProductController::class, 'imageDestroy'])->name('product.image.delete');
    });

    Route::prefix('users')->middleware('role:superadmin')->group(function() {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('edit/{uuid}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('update/{uuid}', [UserController::class, 'update'])->name('user.update');
        Route::delete('delete/{uuid}', [UserController::class, 'destroy'])->name('user.delete');
    });

    Route::prefix('profile')->group(function() {
        Route::get('', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('update', [ProfileController::class, 'update'])->name('profile.update');
    });

});
