<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\SuperAdminAuthController;
use App\Http\Controllers\DashboardController;
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

Route::middleware(['guest.custom'])->group(function () {
    Route::get('/login', [SuperAdminAuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [SuperAdminAuthController::class, 'showRegisterForm'])->name('register');

});

Route::post('/login', [SuperAdminAuthController::class, 'login']);
Route::post('/register', [SuperAdminAuthController::class, 'register']);

Route::post('/superadmin/logout', [SuperAdminAuthController::class, 'logout'])->name('logout');



Route::middleware(['isSuperAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::get('/dashboard/data', [DashboardController::class, 'getChartData'])->name('dashboard.data');
Route::get('/stock', [App\Http\Controllers\ObatController::class, 'index'])->name('stok.index');
Route::post('/stock/store', [App\Http\Controllers\ObatController::class, 'store'])->name('stok.store');
Route::get('/stock/destroy', [App\Http\Controllers\ObatController::class, 'create'])->name('stok.destroy');
Route::get('/stock/edit/{id}', [App\Http\Controllers\ObatController::class, 'edit'])->name('stok.edit');
Route::put('/stock/update/{id}', [App\Http\Controllers\ObatController::class, 'update'])->name('stok.update');
Route::delete('/stock/delete/{id}', [App\Http\Controllers\ObatController::class, 'destroy'])->name('stok.delete');
Route::get('/stock/history/{id}', [App\Http\Controllers\ObatController::class, 'show'])->name('stok.show');



Route::get('/akun', [App\Http\Controllers\AkunController::class, 'index'])->name('akun');
Route::get('/akuh/create', [App\Http\Controllers\AkunController::class, 'create'])->name('akun.create');
Route::post('/akuh/store', [App\Http\Controllers\AkunController::class, 'store'])->name('akun.store');
Route::get('/akun/edit/{id}', [App\Http\Controllers\AkunController::class, 'edit'])->name('akun.edit');
Route::post('/akun/update/{id}', [App\Http\Controllers\AkunController::class, 'update'])->name('akun.update');
Route::post('/akun/hapus/{id}', [App\Http\Controllers\AkunController::class, 'destroy'])->name('akun.destroy');

Route::post('/akun/history', [App\Http\Controllers\HistoryController::class, 'store'])->name('history.store');
Route::delete('/akun/destroy/{id}', [App\Http\Controllers\HistoryController::class, 'destroy'])->name('history.destroy');
Route::get('/export/history-pengeluaran/{id}', [App\Http\Controllers\HistoryController::class, 'exportPDF'])->name('history.export.pdf');


Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan');
Route::post('/laporan', [App\Http\Controllers\LaporanController::class, 'filter'])->name('laporan.filter');
Route::get('/laporan/pdf', [App\Http\Controllers\LaporanController::class, 'exportPDF'])->name('laporan.export.pdf');
Route::get('/laporan/excel', [App\Http\Controllers\LaporanController::class, 'exportExcel'])->name('laporan.export.excel');