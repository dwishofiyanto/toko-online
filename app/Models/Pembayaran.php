<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function pelanggan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan','id');
    }
}
