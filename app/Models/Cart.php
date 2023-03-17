<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class, 'id_pelanggan', 'id');
    }
    public function product()
    {
        return $this->belongsTo(product::class, 'id_barang', 'id');
    }
}
