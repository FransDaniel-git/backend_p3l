<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PegawaiController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\DonasiBarangController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\BarangDonasiController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\Inventory\JabatanController;
use App\Http\Controllers\Inventory\BarangController;
use App\Http\Controllers\Operation\KategoriController;
use App\Http\Controllers\Operation\SubkategoriController;

Route::middleware('auth:api')->group(function() {
    Route::get('/user', [PelangganController::class, 'index']);
    Route::get('/user/{id}', [PelangganController::class, 'showId']);
    
    Route::put('/user/update/{id}', [PelangganController::class, 'update']);
    Route::delete('/user/delete/{id}', [PelangganController::class, 'destroy']);

    //Route::get('/pegawai', [PegawaiController::class, 'index']);
    //Route::get('/pegawai/{id}', [PegawaiController::class, 'show']);
    //Route::put('/pegawai/{id}', [PegawaiController::class, 'update']);
    //Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy']);
    //Route::post('/pegawai', [PegawaiController::class, 'store']);

    //Route::get('/jabatans', [JabatanController::class, 'index']);
    //Route::get('/jabatans/{id}', [JabatanController::class, 'show']);
    //Route::post('/jabatans', [JabatanController::class, 'store']);
    //Route::put('/jabatans/{id}', [JabatanController::class, 'update']);
    //Route::delete('/jabatans/{id}', [JabatanController::class, 'destroy']);

    //Route::get('/barangs', [BarangController::class, 'index']);
    //Route::get('/barang/{kode_barang}', [BarangController::class, 'getDetail']);

    //Route::get('/kategoris', [KategoriController::class, 'index']);
    //Route::get('/subkategoris', [SubkategoriController::class, 'index']);

    Route::get('/permohonan', [PermohonanController::class, 'index']);

    Route::get('/donasi-barang/organisasi/{id}', [DonasiBarangController::class, 'getByOrganisasi']);
    Route::post('/donasi-barang', [DonasiBarangController::class, 'store']);
    Route::put('/donasi-barang/{id}/created-at', [DonasiBarangController::class, 'updateCreatedAt']);

    Route::post('/donasi', [DonasiController::class, 'store']);

    Route::put('/barang-donasi/{id}/status', [BarangDonasiController::class, 'updateStatus']);

    Route::put('/organisasi/{id}/update-penerima', [OrganisasiController::class, 'updateNamaPenerima']);

    Route::put('/penitip/{id}/tambah-poin', [PenitipController::class, 'tambahPoin']);
});
//tanpa token
Route::post('/user/store', [PelangganController::class, 'store']);
Route::post('/user/login', [PelangganController::class, 'login']);
Route::post('verify-email', [PelangganController::class, 'verifyEmail']);

Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::get('/pegawai/{id}', [PegawaiController::class, 'show']);
Route::put('/pegawai/{id}', [PegawaiController::class, 'update']);
Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy']);
Route::post('/pegawai', [PegawaiController::class, 'store']);

Route::get('/jabatans', [JabatanController::class, 'index']);
Route::get('/jabatans/{id}', [JabatanController::class, 'show']);
Route::post('/jabatans', [JabatanController::class, 'store']);
Route::put('/jabatans/{id}', [JabatanController::class, 'update']);
Route::delete('/jabatans/{id}', [JabatanController::class, 'destroy']);

Route::get('/barangs', [BarangController::class, 'index']);
Route::get('/barang/{kode_barang}', [BarangController::class, 'getDetail']);

Route::get('/kategoris', [KategoriController::class, 'index']);
Route::get('/subkategoris', [SubkategoriController::class, 'index']);
