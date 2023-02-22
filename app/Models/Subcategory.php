<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

//     public function kategoori1()
// {
//     return $this->belongsTo('App\Models\Category');
// }
}
