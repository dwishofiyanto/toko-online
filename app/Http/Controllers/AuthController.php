<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    //

    public function index()
    {
        return view('auth.login');
    }
    public function form_login_pelanggan(Request $request)
    {
        $search = $request->search;
        return view('pelanggan.login.login', ['search' => $search]);
    }
    public function form_daftar_pelanggan(Request $request)
    {
        $search = $request->search;
        return view('pelanggan.daftar.daftar', ['search' =>$search]);
    }
    public function login(Request $request){
        // $credentials = request(['email', 'password']);

        // if (! $token = auth()->attempt($credentials)) {
        //     return response()->json(['error' => 'email atau password salah'], 401);
        // }

        // return $this->respondWithToken($token);

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $token = Auth::guard('api')->attempt($credentials);
            return response()->json([
                'success' => true,
                'message' => 'login berhasil',
                'token' => $token]);
        //    $token = Auth::guard('api')->attempt($credentials);
        //    cookie()->queue(cookie('token', $token, 60));
        //    return redirect('/dashboard');
        }
        return response()->json([
            'success' => false,
            'message' => 'email tau password salah'
        ]);
        // return back()->withErrors([yes
        //     'errors' => 'email pass salah']);
       // return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function daftar_pelanggan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required',
            'email' => 'required|email',
          
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        // $pelanggan = App\Models\Pelanggan::create([
        //     'nama_pelanggan' => 'ss',
        //     'email' => 'mail@laravel.web.id',
        //     'password' => bcrypt('secret')
        //   ]);
      // $product = Pelanggan::create($input);
    //   Pelanggan::create(request([
    //     'nama_pelanggan' => request('nama_pelanggan'),
    //     'email' => request('email'),
    //     'password' => request('password'),
    //     'no_hp' => request('password'),
    //     'provinsi' => request('password')
       
    // ]));
       $pelanggan = new Pelanggan;
 
       $pelanggan->nama_pelanggan = $request->nama_pelanggan;
       $pelanggan->email = $request->email;
       $pelanggan->password = bcrypt($request->password);
       
       $pelanggan->save();

       if($pelanggan)
       {
       return response()->json(['status' => 1, 'msg'=>'Berhasil mendaftar','data' => $pelanggan]);
    }
    else
    {
        return response()->json(['status'=> 1, 'msg'=>'Gagal mendaftar', 'data'=>$pelanggan]);
    }
    
    }

    public function login_pelanggan(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'=> 'required'
           
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        //$credentials = $request->only('email','password');
        $pelanggan = Pelanggan::where('email', $request->email)->first();
            
       
        if($pelanggan)
        {
            if(Hash::check($request->password, $pelanggan->password))
            {
               // $token = Auth::guard('api')->attempt($credentials);
               $request->session()->regenerate();
                echo "berhasil";
                // return response()->json(['
                // message' => 'succees',
                // 'data' => $pelanggan]);
            }
            else
            {
                return response()->json(['
                message' => 'fail',
                'data' => 'password wrong']);
            }
        }
        else
        {
            return response()->json(['
            message' => 'fail',
            'data' => 'email wrongg']);
        }
       
    }
    public function logout()
    {  auth()->logout();

        return redirect('/login');
    }
    public function logout_pelanggan()
    {
        auth()->logout();
        return redirect('/pelanggan/login');
     //   return response()->json(['message' => 'Successfully logged out']);
    }

}
