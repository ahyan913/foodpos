<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Type as ModelsProductType;
use App\Models\TypeProduct;
use Illuminate\Database\Seeder;

class ProductType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productType = new ModelsProductType();
        $productType->name = "Default";
        $productType->status = 1;
        $productType->locale = json_decode('{"en_US":{"name":"Default","description":"Default"},"zh_HK":{"name":"\u4e00\u822c\u98df\u54c1","description":"\u4e00\u822c\u98df\u54c1"}}', true);
        $productType->image = "1692896664.jpg";
        $productType->save();

        foreach(Product::get() as $product){

            $typeProduct = new TypeProduct();
            $typeProduct->type_id = $productType->id;
            $typeProduct->product_id = $product->id;
            $typeProduct->save();

        }


    }
}
