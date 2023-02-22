<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        // $id=$this->get('id');
        // $id
        $categori = Category::all();
        return response()->json(['data' => $categori]);
    }
    public function kategori_pelanggan()
    {
      //  $categori = Category::all();

        return view('pelanggan.home.index');
    }
    public function list_web()
    {
        return view('kategori.index');
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
       // $this->middleware('auth:api');
        //
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 423);
        }

        $input = $request->all();
        if($request->has('gambar'))
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
       }
        $kategori = Category::create($input);
        return response()->json(['data' => $kategori]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        //
        $categori = Category::findOrFail($category);
        return response()->json(['data' => $categori]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
       // dd($categori);
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        if($request->has('gambar'))
        {
          
            File::delete('uploads/' . $category->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        else
        {   unset($input['gambar']);    }
      
        $category->update($input);
        return response()->json([
            'data' => $category->deskripsi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
         //$this->middleware('auth:api')->except(['index']);
          
       

   //  $this->middleware('auth:api');
        //
        $categori = Category::findOrFail($id);
        File::delete('uploads/' . $categori->id);
        $categori->delete();
        return response()->json([
                'message' => 'success'
            ]);
       // $categori->delete();
        // return response()->json([
        //     'message' => $id
        // ]);
        // File::delete('uploads/' . $category->gambar);
        // $category->delete();
        // return response()->json([
        //     'message' => 'successs'
        // ]);
    }

}
