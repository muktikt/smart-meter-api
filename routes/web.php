<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\GangguanController;

Route::get('/', function () {
    return view('auth.login');
});
Route::view('/login', 'auth.login');
Route::post('/login', [AuthController::class, 'adminLogin']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/laporan', [LaporanController::class, 'index']);
Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf']);
Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel']);

Route::get('/monitoring', [MonitoringController::class, 'index']);
Route::get('/monitoring/realtime', [MonitoringController::class, 'realtime']);
Route::get('/monitoring/anomali', [MonitoringController::class, 'anomali']);

Route::get('/pelanggan', [PelangganController::class, 'index']);
Route::get('/pelanggan/create', [PelangganController::class, 'create']);
Route::post('/pelanggan/store', [PelangganController::class, 'store']);
Route::get('/pelanggan/detail/{id}', [PelangganController::class, 'detail']);
Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit']);
Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update']);
Route::post('/pelanggan/nonaktif/{id}', [PelangganController::class, 'nonaktif']);
Route::delete('/pelanggan/delete/{id}', [PelangganController::class, 'destroy']);
Route::get('/pelanggan/export-excel', [PelangganController::class, 'exportExcel']);
Route::get('/pelanggan/anomali', [PelangganController::class, 'anomali']);

Route::get('/petugas', [PetugasController::class, 'index']);
Route::get('/petugas/create', [PetugasController::class, 'create']);
Route::post('/petugas/store', [PetugasController::class, 'store']);
Route::get('/petugas/export-excel', [PetugasController::class, 'exportExcel']);
Route::get('/petugas/detail/{id}', [PetugasController::class, 'detail']);
Route::get('/petugas/edit/{id}', [PetugasController::class, 'edit']);
Route::post('/petugas/update/{id}', [PetugasController::class, 'update']);
Route::post('/petugas/nonaktif/{id}', [PetugasController::class, 'nonaktif']);
Route::delete('/petugas/delete/{id}', [PetugasController::class, 'destroy']);
Route::get('/petugas/reset-device/{id}', [PetugasController::class, 'resetDevice']);
Route::get('/petugas/block/{id}', [PetugasController::class, 'block']);
Route::get('/petugas/export-excel', [PetugasController::class, 'exportExcel']);

Route::get('/admin-profile', [ProfileController::class, 'index']);
Route::post('/admin-profile/update', [ProfileController::class, 'update']);
Route::post('/admin-profile/update-password', [ProfileController::class, 'updatePassword']);
Route::post('/admin-profile/upload-foto', [ProfileController::class, 'uploadFoto']);
Route::post('/admin-profile/logout-all', [ProfileController::class, 'logoutAll']);

Route::get('/meter', [MeterController::class, 'index']);
Route::get('/meter/detail/{id}', [MeterController::class, 'detail']);
Route::get('/meter/anomali', [MeterController::class, 'anomaliView']);
Route::get('/meter/export-excel', [MeterController::class, 'exportExcel']);
Route::get('/meter/validasi/{id}', [MeterController::class, 'validasi']);
Route::get('/meter/warning/{id}', [MeterController::class, 'warning']);

Route::get('/tagihan', [TagihanController::class, 'webIndex']);
Route::get('/tagihan/detail/{id}', [TagihanController::class, 'detail']);

Route::get('/pengaduan', [PengaduanController::class, 'index']);
Route::get('/pengaduan/detail/{id}', [PengaduanController::class, 'detail']);
Route::get('/pengaduan/proses/{id}', [PengaduanController::class, 'proses']);
Route::post('/pengaduan/update-proses/{id}', [PengaduanController::class, 'updateProses']);
Route::get('/pengaduan/export-excel', [PengaduanController::class, 'exportExcel']);


Route::get('/gangguan', [GangguanController::class, 'webIndex']);
Route::get('/gangguan/create', [GangguanController::class, 'create']);
Route::get('/gangguan/detail/{id}', [GangguanController::class, 'detail']);
Route::post('/gangguan/store', [GangguanController::class, 'store']);
Route::get('/gangguan/selesai/{id}', [GangguanController::class, 'selesai']);

Route::post('/logout', [AuthController::class, 'logout']);