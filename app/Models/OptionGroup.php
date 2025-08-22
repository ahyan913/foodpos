<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\Models\Constant\OptionType;
use App\Models\Constant\Status;
use App\Models\ProductOption;

class OptionGroup extends Model
{
    use HasFactory;

    const TABLE = "option_groups";
    protected $table = "option_groups";
    protected $fillable = ["locale","option_id","status","sort_order"];
    protected $casts = ["locale"=>"array"];
    protected $appends = ["options"];

    public function getOptionsAttribute(){
        if($this->type == OptionType::PRODUCT){
            $relation = ProductOption::with([
                "product"=>function($query){ $query->select("id","locale","price")->where("status", Status::ACTIVE); }

            ]);
        }else{
            $relation = Option::select("id", "locale", "price","option_group_id")->where("status", Status::ACTIVE);
        }
        return $relation->where("option_group_id", $this->id)->get();
    }

    public function productOptions(){
        return $this->hasMany(ProductOption::class, "option_group_id", "id");
    }

    public function productOptionProducts(){
        $relationship = $this->hasManyThrough(Product::class, ProductOption::class,"product_id","id");
        return $relationship;
    }

    public function options(){
        return $this->hasMany(Option::class, "option_group_id", "id");
    }



    public function getOptions(){
        switch($this->type){
            case OptionType::NORMAL:
                return $this->options();
            case OptionType::PRODUCT:
                return $this->productOptions();
            default:
                return [];
        }
    }

}
