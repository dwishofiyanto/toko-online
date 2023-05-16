<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PelangganFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort;
        $page = $request->page;
        return view("pelanggan.home.index", [
            "page" => $page,
            "sort" => $sort,
            "search" => $search,
        ]);

        //     $response = Http::get('http://127.0.0.1:8000/api/produk');
        // $data = $response->json();

        // $perPage = 10;
        // $currentPage = request()->query('page', 1);
        // $data = collect($data)->paginate($perPage, ['*'], 'page', $currentPage);

        // return view('pelanggan.home.cek', ['data' => $data]);
        //    return view("pelanggan.home.index");
    }
    public function post_login(Request $request)
    {
        //  return $request->email;
        $tes = Http::post("http://127.0.0.1:8000/api/auth/login_pelanggan", [
            "email" => $request->email,
            "password" => $request->password,
        ]);

        $response = $tes->getBody();
        $response = json_decode($response, true);

        dd($response);
    }
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
