<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Slidder;
use Illuminate\Http\Request;



class SlidderController extends Controller
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
        
        $slidder = Slidder::all();
        return response()->json(['data' => $slidder]);
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
        
        $validator = Validator::make($request->all(), [
            'nama_slidder' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        if($validator->fails()){
           // return response()->json($validator->errors(), 422);
           return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else
        {
            $input = $request->all();
            if($request->has('gambar'))
            {
                $gambar = $request->file('gambar');
                $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
                $gambar->move('uploads', $nama_gambar);
                $input['gambar'] = $nama_gambar;
            }
            $kategori = Slidder::create($input);
            if($kategori)
            {
                return response()->json(['status'=> 1, 'msg'=>'Data berhasil ditambahkan', 'data'=>$kategori]);
            }
            else
            {
                return response()->json(['status'=>1, 'msg'=>'Data gagal ditambahkan']);
            }
             // return response()->json(['data' => $kategori]);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slidder  $slidder
     * @return \Illuminate\Http\Response
     */
    public function show(Slidder $slidder)
    {
        //
        return response()->json(['data' => $slidder]);
    }
    public function list_web()
    {
        return view('slidder.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slidder  $slidder
     * @return \Illuminate\Http\Response
     */
    public function edit(Slidder $slidder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slidder  $slidder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slidder $slidder)
    {
        //
        
        $validator = Validator::make($request->all(), [
            'nama_slidder' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
           
        ]);
        if($validator->fails()){
            // return response()->json($validator->errors(), 422);
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
         }
         else
         {

        $input = $request->all();
        if($request->has('gambar'))
        {
            File::delete('uploads/' . $slidder->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        else
        {
            unset($input['gambar']);
        }
        $slidder->update($input);
        if($slidder)
        {
            return response()->json(['status'=> 1, 'msg'=>'Data berhasil diedit', 'data'=>$slidder]);
        }
        else
        {
            return response()->json(['status'=>1, 'msg'=>'Data gagal edit']);
        }
        
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slidder  $slidder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slidder $slidder)
    {
        //
        File::delete('uploads/' . $slidder->gambar);
        $slidder->delete();
        return response()->json([
            'message' => 'succes'
        ]);
    }
}
