<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Pesanan;
use App\Models\Pesanandetail;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function __construct()
    {
      
        $this->middleware('auth')->only(['list_web']);
        $this->middleware('auth:api')->only(['store','update','delete','baru','ubah_status','dikonfirmasi','dikemas','dikirim','diterima','selesai']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pesanan = Pesanan::with('pelanggan')->get();
        return response()->json(['data' => $pesanan]);
    }

    public function list_baru()
    {
        return view('pesanan.baru');
    }
    public function list_dikonfirmasi()
    {
        return view('pesanan.dikonfirmasi');
    }
    public function list_dikemas()
    {
        return view('pesanan.dikemas');
    }
    public function list_dikirim()
    {
        return view('pesanan.dikirim');
    }
    public function list_diterima()
    {
        return view('pesanan.diterima');
    }
    public function list_selesai()
    {
        return view('pesanan.selesai');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'id_pelanggan' => 'required',
            'invoice' => 'required',
            'grand_total' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $input = $request->all();
        $pesanan = Pesanan::create($input);
        for ($i=0; $i < count($input['id_produk']) ; $i++) { 
            Pesanandetail::create([
                'id_pesanan' => $pesanan['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'warna'=> $input['warna'[$i]],
                'total' => $input['total'][$i]
            ]);
        }
        return response()->json(['data' => $pesanan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function show(Pesanan $pesanan)
    {
        //
        return response()->json(['data' => $pesanan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        //
        $validator = Validator::make($request->all(), [
            'id_pelanggan' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
       
        $pesanan->update($input);
        Pesanandetail::where('id_pesanan', $pesanan['id'])->delete();
        $pesanan = Pesanan::create($input);
        for ($i=0; $i < count($input['id_produk']) ; $i++) { 
            Pesanandetail::create([
                'id_pesanan' => $pesanan['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'warna'=> $input['warna'[$i]],
                'total' => $input['total'][$i]
            ]);
        }
        return response()->json([
            'message'=> 'berhasil',
            'data' => $pesanan
        ]);
    }
    public function baru()
    {
        $pesanan = Pesanan::with('pelanggan')->where('status', 'Baru')->get();
        return response()->json([
            'data' => $pesanan
        ]);
    }
    public function dikonfirmasi()
    {
        $pesanan = Pesanan::with('pelanggan')->where('status', 'Dikonfirmasi')->get();
        return response()->json([
            'data' => $pesanan
        ]);
    }
    public function dikemas()
    {
        $pesanan = Pesanan::with('pelanggan')->where('status', 'Dikemas')->get();
        return response()->json([
            'data' => $pesanan
        ]);
    }
    public function dikirim()
    {
        $pesanan = Pesanan::with('pelanggan')->where('status', 'Dikirim')->get();
        return response()->json([
            'data' => $pesanan
        ]);
    }
    public function diterima()
    {
        $pesanan = Pesanan::with('pelanggan')->where('status', 'Diterima')->get();
        return response()->json([
            'data' => $pesanan
        ]);
    }
    public function selesai()
    {
        $pesanan = Pesanan::with('pelanggan')->where('status', 'Selesai')->get();
        return response()->json([
            'data' => $pesanan
        ]);
    }
    public function ubah_status($id)
    {
       // $flight = Flight::find($id);
       
        // $input = $request;
        // return $input;
        $pesanan = Pesanan::findOrFail($id);
     
        $pesanan->status = request('status');
         
        $pesanan->save();
        // $pesanan->update([
        //     'status' => $request->status
        // ]);
        return response()->json([
            'data'=>$pesanan
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pesanan  $pesanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pesanan $pesanan)
    {
        //
    }
}
