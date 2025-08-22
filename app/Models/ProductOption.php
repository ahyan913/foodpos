<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductOption extends Model
{
    use HasFactory;

    protected $fillable = ["code", "data", "locale", "type"];
    protected $casts = ["locale"=>"array"];

    public function product(){
        return $this->hasOne(Product::class, "id", "product_id")->with("optionGroups");
    }
}
