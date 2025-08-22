<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\TypeToProduct;

class Type extends Model
{
    use HasFactory;
    const TABLE = "type";
    protected $table = "type";
    protected $fillable = ["name","status"];
    protected $casts = ["locale"=>"array"];

    public function types(){
        return $this->belongsToMany(Product::class, TypeToProduct::TABLE, "type_id", "product_id");
    }

}
