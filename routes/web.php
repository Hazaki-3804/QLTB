<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\quanlydonvi\DonViController;
use App\Http\Controllers\quanlydonvi\PhongKhoController;
use App\Http\Controllers\quanlytaikhoan\LoaiTaikhoanController;
use App\Http\Controllers\quanlytaikhoan\TaikhoanController;
use App\Http\Controllers\ghisonhatky\NhatKyPhongMayController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('layouts.app');
    })->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Password reset routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// DonVi routes
Route::middleware('auth')->group(function () {
    Route::prefix('donvi')->name('donvi.')->group(function () {
        Route::get('/', [DonViController::class, 'index'])->name('index');
        Route::post('/create', [DonViController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DonViController::class, 'edit'])->name('edit');
        Route::put('/upd/{id}', [DonViController::class, 'update'])->name('update');
        Route::delete('/del/{id}', [DonViController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('phongkho')->name('phongkho.')->group(function () {
        Route::get('/', [PhongKhoController::class, 'index'])->name('index');
        Route::post('/create', [PhongKhoController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [PhongKhoController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [PhongKhoController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [PhongKhoController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('loaitaikhoan')->name('loaitaikhoan.')->group(function () {
        Route::get('/', [LoaiTaikhoanController::class, 'index'])->name('index');
        Route::post('/create', [LoaiTaikhoanController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [LoaiTaikhoanController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [LoaiTaikhoanController::class, 'edit'])->name('edit');
    });
    Route::prefix('taikhoan')->name('taikhoan.')->group(function () {
        Route::get('/', [TaikhoanController::class, 'index'])->name('index');
        Route::post('/create', [TaikhoanController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [TaikhoanController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [TaikhoanController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [TaikhoanController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('nhatkyphongmay')->name('nhatkyphongmay.')->group(function () {
        Route::get('/', [NhatKyPhongMayController::class, 'index'])->name('index');
        Route::post('/create', [NhatKyPhongMayController::class, 'store'])->name('store');
        Route::put('/upd', [NhatKyPhongMayController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [NhatKyPhongMayController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [NhatKyPhongMayController::class, 'destroy'])->name('destroy');
        Route::get('/search-phong', [NhatKyPhongMayController::class, 'searchPhongMay'])->name('search-phong');
        Route::get('/loadTable', [NhatKyPhongMayController::class, 'loadTable'])->name('loadTable');
    });
});
