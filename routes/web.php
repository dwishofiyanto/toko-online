<?php
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

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
use App\Http\Controllers\PelangganFrontController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\HomeController;

class Paginate
{
    public static function generate(
        $items,
        $perPage = 5,
        $page = null,
        $options = []
    ): LengthAwarePaginator {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items =
            $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }
}

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

Route::get("coba", function (Request $req) {
    $url = "http://127.0.0.1:8000/api/produk";

    $res = Http::get($url)->json();

    $data = Paginate::generate($res["data"], $length = 2, $req->query("page"), [
        "path" => "coba",
    ]);
    return view("page", ["data" => $data]);
});

Route::get("users2/", function (\Illuminate\Http\Request $request) {
    return paginateFromApi(
        "http://127.0.0.1:8000/api/produk/",
        $request->get("per_page", 1)
    );
});

//Route::get('/', function () {return view('pelanggan.home.index');});
Route::get("/load", function () {
    return view("load");
});
Route::get("/keranjang", function () {
    return view("pelanggan.cart.cart");
});

Route::get("/", [PelangganFrontController::class, "home"]);
Route::post("login", [AuthController::class, "login"]);
//Route::post('daftar_pelanggan',[AuthController::class, 'daftar_pelanggan']);
Route::get("logout", [AuthController::class, "logout"]);
Route::get("logout_pelanggan", [AuthController::class, "logout_pelanggan"]);
Route::get("login", [AuthController::class, "index"])->name("login");
Route::get("admin/", [DashboardController::class, "index"]);
Route::get("admin/dashboard", [DashboardController::class, "index"]);
Route::get("admin/pelanggan", [PelangganController::class, "list_web"]);
Route::get("admin/kategori", [CategoryController::class, "list_web"]);
Route::get("admin/subkategori", [SubcategoryController::class, "list_web"]);
Route::get("admin/slidder", [SlidderController::class, "list_web"]);
Route::get("admin/produk", [ProductController::class, "list_web"]);
Route::get("pesanan", [PesananController::class, "list_web"]);
Route::get("admin/pesanan/baru", [PesananController::class, "list_baru"]);
Route::get("admin/pesanan/dikonfirmasi", [
    PesananController::class,
    "list_dikonfirmasi",
]);
Route::get("admin/pesanan/dikemas", [PesananController::class, "list_dikemas"]);
Route::get("admin/pesanan/dikirim", [PesananController::class, "list_dikirim"]);
Route::get("admin/pesanan/diterima", [
    PesananController::class,
    "list_diterima",
]);
Route::get("admin/pesanan/selesai", [PesananController::class, "list_selesai"]);
Route::get("admin/laporan", [LaporanController::class, "list_web"]);
Route::get("admin/pembayaran", [PembayaranController::class, "list_web"]);
Route::get("pelanggan/login", [AuthController::class, "form_login_pelanggan"]);
Route::get("pelanggan/daftar", [
    AuthController::class,
    "form_daftar_pelanggan",
]);
// Route::post('pelanggan/login', [PelangganFrontController::class, 'post_login']);

Route::get("/cart/", [HomeController::class, "cart"]);
Route::post("/add_to_cart", [HomeController::class, "add_to_cart"]);

//Route::post('api/daftar_pelanggan', [AuthController::class, 'daftar_pelanggan']);
