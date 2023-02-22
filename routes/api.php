<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SlidderController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function(){
    Route::post('admin',[AuthController::class, 'login']);
    Route::post('daftar_pelanggan',[AuthController::class, 'daftar_pelanggan']);
    Route::post('login_pelanggan',[AuthController::class, 'login_pelanggan']);
    Route::post('login',[AuthController::class, 'login']);
    Route::post('logout',[AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'api'
], function(){
    Route::resources([
        'kategori'=>CategoryController::class,
        'subkategori' =>SubcategoryController::class,
        'slidder' =>SlidderController::class,
        'product' =>ProductController::class,
        'pelanggan' =>PelangganController::class,
        'ulasan' =>UlasanController::class,
        'testimoni' =>TestimoniController::class,
        'pembayaran' =>PembayaranController::class,
        'produk'=>ProductController::class]);
    
    Route::get('cek', [CategoryController::class,'edit']);
   // Route::get('pesanan/baru', [PesananController::class,'baru']);
    Route::get('pesanan/dikonfirmasi', [PesananController::class,'dikonfirmasi']);
    Route::get('pesanan/dikemas', [PesananController::class,'dikemas']);
    Route::get('pesanan/dikirim', [PesananController::class,'dikirim']);
    Route::get('pesanan/diterima', [PesananController::class,'diterima']);
    Route::get('pesanan/selesai', [PesananController::class,'selesai']);
    Route::post('pesanan/ubah_status/{id}', [PesananController::class,'ubah_status']);
     Route::get('laporan', [LaporanController::class,'index']);
    // Route::post('kategori/', [CategoryController::class,'store']);
    // Route::post('kategori/{id}', [CategoryController::class,'update']);
    // Route::delete('kategori/{id}', [CategoryController::class,'destroy']);
    // Route::get('kategori/', [CategoryController::class,'index']);
    // Route::get('kategori/{id}', [CategoryController::class,'show']);

    
   
   
});