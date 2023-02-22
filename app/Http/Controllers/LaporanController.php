<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct()
    {
    // $this->middleware('auth:api')->except(['index']);
    $this->middleware('auth')->only(['list_web']);
    $this->middleware('auth:api')->only(['index']);
      
    }
    //
    public function index(Request $request)
    {
        $laporan = DB::table('pesanan_details')
        ->join('products', 'products.id', '=', 'pesanan_details.id_produk')
        ->select(DB::raw('
        count(*) as jumlah_dibeli,
        nama_barang,
        harga,
        sum(total) as pendapatan,
        sum(jumlah) as total_qty
        '))
        ->whereraw("date(pesanan_details.created_at) >= '$request->dari'")
        ->whereraw("date(pesanan_details.created_at) <= '$request->sampai'")
        ->groupBy('id_produk', 'nama_barang', 'harga')
        ->get();

        return response()->json([
            'data' => $laporan

        ]);
    }

    public function list_web()
    {
        return view('laporan.index');
    }
}
