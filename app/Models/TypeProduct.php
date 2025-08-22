<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProduct extends Model
{
    const TABLE = "type_product";
    protected $table = "type_product";
    use HasFactory;
    public $fillable = ["type_id", "product_id"];

    public static function getProductIdsByProductTypeId($productTypeId){
        $ids = [];
        if($staffRoles = self::where("type_id", $productTypeId))
            $ids = $staffRoles->pluck("product_id")->toArray();
        return $ids;
    }

    public static function getProductTypeIdsByProductId($productId){
        $ids = [];
        if($staffRoles = self::where("product_id", $productId))
            $ids = $staffRoles->pluck("type_id")->toArray();

        return $ids;
    }

    public static function updateProductIdsByProductTypeId($productTypeId, $productIds = []){

        $productIds = $productIds ?? [];
        $_productIds = self::getProductIdsByProductTypeId($productTypeId);
        $insertIds = array_diff($productIds, $_productIds);
        $deleteIds = array_diff($_productIds, $productIds);
        foreach($insertIds as $productId){
            self::create([
                "product_id"=>$productId,
                "type_id"=>$productTypeId
            ]);
        }
        if($deleteIds){
            self::where("type_id",$productTypeId)
                ->whereIn("product_id", $deleteIds)
                ->delete();
        }
    }

    public static function updateProductTypeIdsByProductId($productId, $productTypeIds = []){

        $_productTypeIds = self::getProductTypeIdsByProductId($productId);

        $insertIds = array_diff($productTypeIds, $_productTypeIds);
        $deleteIds = array_diff($_productTypeIds, $productTypeIds);

        foreach($insertIds as $id){
            self::create([
                "product_id"=>$productId,
                "type_id"=>$id
            ]);
        }

        if($deleteIds){
            self::where("product_id",$productId)
                ->whereIn("type_id", $deleteIds)
                ->delete();
        }

    }

}
