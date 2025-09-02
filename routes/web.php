<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController;




Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});



// Grup untuk Rute yang Membutuhkan Autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // --- RUTE BARU UNTUK MANAJEMEN AKSES ---
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class); 
    Route::resource('menus', MenuController::class);



    // -----------------------------------------

    // --- RUTE BARU UNTUK MANAJEMEN Barang ---
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    // -----------------------------------------


    // --- RUTE UNTUK PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('audit-logs', [ActivityLogController::class, 'index'])->name('audit-logs.index');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
