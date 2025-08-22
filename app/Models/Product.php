<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\TypeProduct;
use App\Models\OptionGroup;
use Throwable;

class Product extends Model
{
    use HasFactory;
    public $table = "product";
    public $fillable = ["name","locale"];
    protected $casts = ["locale"    =>  "array"];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return url("/api/images/thumbnails/product/".$this->image);
    }

    public function types(){
        return $this->belongsToMany(Type::class, TypeProduct::TABLE, "product_id", "type_id");
    }

    public function optionGroups(){
        $results = $this->belongsToMany(OptionGroup::class, ProductOptionGroups::class, "product_id", "option_group_id");
        return  $results;
    }

    public function getOptionGroupIds(){
        return $this->optionGroups->pluck("id")->toArray();
    }

    public function getProductTypeIds(){
        return $this->types->pluck("id")->toArray();
    }

    public function getThumbnailPath(){

        if($this->image){
            try{
                $file = explode(".", $this->image);

                $extension = array_pop($file);
                $filename = implode(".", $file);
                return "$filename@thumbnail.$extension";

            }catch(Throwable $t){

            }
        }
        return null;
    }
}
