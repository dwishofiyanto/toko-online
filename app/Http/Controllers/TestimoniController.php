<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
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
        $testimoni = Testimoni::all();
        return response()->json(['data' => $testimoni]);
    }
    public function list_web()
    {
        return view('testimoni.index');
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
            'nama_testimoni' => 'required',
            'deskripsi' => 'required',
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
        $testimoni = Testimoni::create($input);
        return response()->json(['data' => $testimoni]);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function show(Testimoni $testimoni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimoni $testimoni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimoni $testimoni)
    {
        //
        return response()->json([
            'data' => $testimoni->deskripsi
        ]);
        $validator = Validator::make($request->all(), [
            'nama_testimoni' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        if($request->has('gambar'))
        {
            File::delete('uploads/' . $testimoni->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        else
        {
            unset($input['gambar']);
        }
        $testimoni->update($input);
        return response()->json([
            'message'=> 'berhasil',
            'data' => $testimoni
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimoni $testimoni)
    {
        //
        //
        File::delete('uploads/' . $testimoni->gambar);
        $testimoni->delete();
        return response()->json([
            'message' => 'succes'
        ]);
    }
}
