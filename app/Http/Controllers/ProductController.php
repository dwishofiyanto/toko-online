<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->only(['list_web']);
        $this->middleware('auth:api')->only(['store','update','delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query_product = Product::with(['categories','subcategories']);
        if($request->sort == 'terrendah')
        {
            $query_product->orderBy('harga','asc');
        }
        if($request->sort == 'tertinggi')
        {
            $query_product->orderBy('harga','desc');
        }
        if($request->sort == 'terbaru')
        {
            $query_product->orderBy('created_at','asc');
        }

        if($request->search)
        {
            $query_product->where('nama_barang', 'LIKE', '%'.$request->search.'%');
        }
        $show = $request->show ?? 1;
        $product = $query_product->get(); 
        return response()->json(['data' =>$product]);
        
    }
    public function list_web()
    {
        return view('produk.index');
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
            'id_kategori' => 'required',
            'id_subkategori' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'bahan' => 'required',
            'tags' => 'required',
            'sku' => 'required',
            'ukuran' => 'required',
            'warna' => 'required',
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
            $product = Product::create($input);
            if($product)
            {
                return response()->json(['status'=> 1, 'msg'=>'Data berhasil ditambahkan', 'data'=>$product]);
            }
            else
            {
                return response()->json(['status'=>1, 'msg'=>'Data gagal ditambahkan']);
            }
       
       

    }

    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        //
       $product = Product::with(['categories','subcategories'])->findOrFail($product);
        //return response()->json(['data' => $categori]);
        return response()->json(['data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        
        $product = Product::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'id_subkategori' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'bahan' => 'required',
            'tags' => 'required',
            'sku' => 'required',
            'ukuran' => 'required',
            'warna' => 'required',
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
            File::delete('uploads/' . $product->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        else
        {
            unset($input['gambar']);
        }
        $product->update($input);

        if($product)
        {
            return response()->json(['status'=> 1, 'msg'=>'Data berhasil diedit', 'data'=>$product]);
        }
        else
        {
            return response()->json(['status'=>1, 'msg'=>'Data gagal ditambahkan','data'=>$product]);
        }
    }
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        File::delete('uploads/' . $product->id);
        $product->delete();
       
        File::delete('uploads/' . $product->gambar);
        $product->delete();
        if($product)
        {
            return response()->json(['status'=> 1, 'msg'=>'Data berhasil dihapus']);
        }
        else
        {
            return response()->json(['status'=>1, 'msg'=>'Data gagal dihapus']);
        }
    }
}
