<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
class HomeController extends Controller
{
    public function cart()
    {
        return "cart";
    }
    public function home(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort;
        $page = $request->page;
     
        $api_url = Http::get('http://127.0.0.1:8000/api/produk/?page='.$page.'&search='.$search.'&sort='.$sort);
        $page= $api_url['data']['links'];
        $response = $api_url->getBody();
       
       $response = json_decode($response, true);
 
       $response = $response['data'];
      
        
       return view('pelanggan.home.index',['produk' => $response, 'page' => $page, 'sort' => $sort, 'search' => $search]);
   
    }
    public function add_to_cart(Request $request)
    {
        $input = $request->all();
        Cart::create($input);
    }
}
