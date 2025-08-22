<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Models\Constant\ProductStatus;

class ProductController extends Controller
{
    public function list(){

        $products = Product::where("status", ProductStatus::ACTIVE)
                        ->with([
                            "types"=>function($query){
                                $query
                                    ->select(["name","status","image","locale"])
                                    ->where("status", 1);
                            },
                            "optionGroups"=>function($query){
                                $query
                                    ->where("status", 1)
                                    ;

                            }
                        ])->get();
        return response()->json($products);
    }
}
