<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\GangguanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\NotificationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/meter/ocr', [MeterController::class, 'ocr']);
Route::post('/upload-meter', [MeterController::class, 'upload']);

Route::get('/tagihan/{user_id}', [TagihanController::class, 'index']);

Route::post('/pengaduan', [PengaduanController::class, 'store']);

Route::get('/gangguan/{kecamatan}', [GangguanController::class, 'index']);

Route::post('/payment/create', [PaymentController::class, 'create']);
Route::get('/payment/status/{id}', [PaymentController::class, 'status']);
Route::post('/payment/webhook', [PaymentController::class, 'webhook']);
Route::post('/payment/cancel/{id}', [PaymentController::class, 'cancel']);

Route::get('/profile/{id}', [UserProfileController::class, 'show']);
Route::put('/profile/update/{id}', [UserProfileController::class, 'update']);

Route::get('/meter/history/{user_id}', [MeterController::class, 'history']);

Route::get('/pengaduan/{user_id}', [PengaduanController::class, 'userHistory']);

Route::get('/notifikasi/{user_id}', [NotificationController::class, 'index']);
Route::put('/notifikasi/read/{id}', [NotificationController::class, 'read']);

use App\Http\Controllers\PetugasController;

Route::post('/petugas/login', [PetugasController::class, 'apiLogin']);
Route::get('/petugas/meter/{petugas_id}', [PetugasController::class, 'apiMeter']);
Route::post('/petugas/meter/validasi/{id}', [PetugasController::class, 'apiValidasiMeter']);
Route::post('/petugas/meter/warning/{id}', [PetugasController::class, 'apiWarningMeter']);
Route::get('/petugas/pengaduan/{petugas_id}', [PetugasController::class, 'apiPengaduan']);
Route::post('/petugas/pengaduan/update/{id}', [PetugasController::class, 'apiUpdatePengaduan']);