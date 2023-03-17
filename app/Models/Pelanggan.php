<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
   // protected $guarded = [];
    protected $fillable = ['nama_pelanggan', 'email', 'password'];
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
