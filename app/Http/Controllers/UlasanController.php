<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function __construct()
    {
    // $this->middleware('auth:api')->except(['index']);
    $this->middleware('auth')->only(['list_web']);
    $this->middleware('auth:api')->only(['store','update','delete']);
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ulasan = Ulasan::all();
        return response()->json(['data' => $ulasan]);
    }
    public function list_web()
    {
        return view('ulasan.index');
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
            'id_produk' => 'required',
            'ulasan' => 'required',
            'rating' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        if($request->has('gambar'))
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        $ulasan = Ulasan::create($input);
        return response()->json(['data' => $ulasan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function show(Ulasan $ulasan)
    {
        //
        return response()->json(['data' => $ulasan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function edit(Ulasan $ulasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ulasan $ulasan)
    {
        //
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required',
            'id_pelanggan' => 'required',
            'ulasan' => 'required',
            'rating' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        if($request->has('gambar'))
        {
            File::delete('uploads/' . $ulasan->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        else
        {
            unset($input['gambar']);
        }
        $ulasan->update($input);
        return response()->json([
            'message'=> 'berhasil',
            'data' => $ulasan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ulasan $ulasan)
    {
        //
        File::delete('uploads/' . $ulasan->gambar);
        $ulasan->delete();
        return response()->json([
            'message' => 'succes'
        ]);
    }
}
