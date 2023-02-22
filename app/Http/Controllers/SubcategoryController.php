<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
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
        $categori = Subcategory::with('categories')->get();
      //  $categori = Subcategory::all();
        return response()->json(['data' => $categori]);
    }
    public function list_web()
    {
        return view('subkategori.index');
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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg',
            'id_kategori' => 'required'
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
        $kategori = Subcategory::create($input);
        return response()->json(['data' => $kategori]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $Subcategory
     * @return \Illuminate\Http\Response
     */
    public function show($Subcategory)
    {
        //
        $Subcategory = Subcategory::findOrFail($Subcategory);
        return response()->json(['data' => $Subcategory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $Subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $Subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $Subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return response()->json([$request->all()]);
        //
        $Subcategory = Subcategory::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg',
            'id_kategori' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        if($request->has('gambar'))
        {
            File::delete('uploads/' . $Subcategory->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        else
        {
            unset($input['gambar']);
        }
        $Subcategory->update($input);
        return response()->json([
            'message'=> 'berhasil',
            'data' => $Subcategory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $Subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($Subcategory);
        $Subcategory = Subcategory::findOrFail($id);
        File::delete('uploads/' . $Subcategory->gambar);
        $Subcategory->delete();
        return response()->json([
            'message' => 'succes'
        ]);
    }
}
