<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Coba;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\SlidderController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('pelanggan.home.index');});
Route::get('/keranjang', function () {return view('pelanggan.cart.cart');});

Route::get('/',[CategoryController::class, 'kategori_pelanggan']);
Route::post('login',[AuthController::class, 'login']);
//Route::post('daftar_pelanggan',[AuthController::class, 'daftar_pelanggan']);
Route::get('logout',[AuthController::class, 'logout']);
Route::get('logout_pelanggan',[AuthController::class, 'logout_pelanggan']);
Route::get('login',[AuthController::class, 'index'])->name('login');
Route::get('admin/', [DashboardController::class, 'index']);
Route::get('admin/dashboard', [DashboardController::class, 'index']);
Route::get('admin/kategori', [CategoryController::class, 'list_web']);
Route::get('admin/subkategori', [SubcategoryController::class, 'list_web']);
Route::get('admin/slidder', [SlidderController::class, 'list_web']);
Route::get('admin/produk', [ProductController::class, 'list_web']);
Route::get('pesanan', [PesananController::class, 'list_web']);
Route::get('admin/pesanan/baru', [PesananController::class, 'list_baru']);
Route::get('admin/pesanan/dikonfirmasi', [PesananController::class, 'list_dikonfirmasi']);
Route::get('admin/pesanan/dikemas', [PesananController::class, 'list_dikemas']);
Route::get('admin/pesanan/dikirim', [PesananController::class, 'list_dikirim']);
Route::get('admin/pesanan/diterima', [PesananController::class, 'list_diterima']);
Route::get('admin/pesanan/selesai', [PesananController::class, 'list_selesai']);
Route::get('admin/laporan', [LaporanController::class, 'list_web']);
Route::get('admin/pembayaran', [PembayaranController::class, 'list_web']);
Route::get('pelanggan/login', [AuthController::class, 'form_login_pelanggan']);
Route::get('pelanggan/daftar', [AuthController::class, 'form_daftar_pelanggan']);
//Route::post('api/daftar_pelanggan', [AuthController::class, 'daftar_pelanggan']);
