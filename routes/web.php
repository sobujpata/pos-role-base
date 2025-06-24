<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleManagementController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function(){
        return view('backend.pages.dashboard');
    })->name('dashboard');
    //Product Route
    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('permission:product-menu|product-view');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:product-create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:product-create');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:product-edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('permission:product-edit');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:product-delete');
    //Role Route
    Route::get('/roles', [RoleManagementController::class, 'index'])->name('roles.index')->middleware('permission:role-menu|role-view');
    Route::get('/roles/create', [RoleManagementController::class, 'create'])->name('role.create')->middleware('permission:role-create');
    Route::post('/roles', [RoleManagementController::class, 'store'])->name('roles.store')->middleware('permission:role-create');
    Route::get('/roles/{id}/edit', [RoleManagementController::class, 'edit'])->name('role.edit')->middleware('permission:role-edit');
    Route::put('/roles/{id}', [RoleManagementController::class, 'update'])->name('role.update')->middleware('permission:role-edit');
    Route::delete('/roles/{id}', [RoleManagementController::class, 'destroy'])->name('role.destroy')->middleware('permission:role-delete');
    //permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index')->middleware('permission:permission-menu|permission-view');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('permission:permission-create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:permission-create');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:permission-edit');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:permission-edit');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('permission:permission-delete');
    //User Route
    Route::get('/users', [UsersController::class, 'index'])->name('users.index')->middleware('permission:user-menu|user-view');
    Route::get('/users/create', [UsersController::class, 'create'])->name('user.create')->middleware('permission:user-create');
    Route::post('/users', [UsersController::class, 'store'])->name('user.store')->middleware('permission:user-create');
    Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('user.edit')->middleware('permission:user-edit');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('user.update')->middleware('permission:user-edit');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('user.destroy')->middleware('permission:user-delete');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
