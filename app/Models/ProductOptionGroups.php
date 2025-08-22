<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductOption;

class ProductOptionGroups extends Model
{
    use HasFactory;
    protected $table = "product_option_groups";


    public static function getOptionGroupIdsByProductId($productId){

        return self::where("product_id", $productId)
                    ->pluck("option_group_id")
                    ->toArray();
    }

    public static function getProductIdsByOptionGroupId($optionGroupId){

        return self::where("option_group_id", $optionGroupId)
                    ->pluck("product_id")
                    ->toArray();
    }


}
