<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helper\ImageHelper;
use App\Models\TypeProduct;
use Illuminate\Support\Facades\DB;
use App\Models\ProductOptionGroups;

class ProductSaveService
{
    const UPLOAD_PATH = "images/product";

    protected $error = "";
    protected $price;
    protected $product;
    protected $uploadImage;
    protected $typeIds;
    protected $optionGroupIds;

    public function initByRequest(Request $request, Product $product = null)
    {

        if(is_null($product)){
            $product = new Product();
        }
        $product->price = $request->input("price");
        $product->name = $request->input("name");
        $product->status = $request->input("status");
        $product->locale = $request->input("locale");
        $this->typeIds = $request->input("type_id");
        $this->uploadImage = $request->file("image");
        $this->product = $product;
        $this->optionGroupIds = $request->input("option_group_ids", []);

        return $this;

    }

    protected function uploadImageFile(){
        if($this->uploadImage){
            $filename = time().".".$this->uploadImage->extension();
            $uploadImagePath = public_path(self::UPLOAD_PATH);
            $srcPath = $uploadImagePath."/".$filename;
            ImageHelper::upload($this->uploadImage, $srcPath);
            $this->product->image = $filename;
        }
    }

    protected function removeUncheckedOptionGroup(){

        if(is_array($this->optionGroupIds)){
            ProductOptionGroups::where("product_id",$this->product->id)->whereNotIn("option_group_id", array_keys($this->optionGroupIds))->delete();
        }

    }

    protected function updateOptionGroup(){

        $optionGroupIds = ProductOptionGroups::getOptionGroupIdsByProductId($this->product->id);

        $newOptionGroupIds = array_diff($this->optionGroupIds, $optionGroupIds);

        foreach($newOptionGroupIds as $index => $optionGroupId){
            $obj = new ProductOptionGroups();
            $obj->option_group_id = $optionGroupId;
            $obj->product_id = $this->product->id;
            $obj->sort_order = $index+1;
            $obj->save();
        }

    }

    public function getError(){
        return $this->error;
    }

    public function save(){
        try{
            DB::beginTransaction();
            $this->uploadImageFile();
            $this->product->save();
            TypeProduct::updateProductTypeIdsByProductId($this->product->id, $this->typeIds);
            $this->removeUncheckedOptionGroup();
            $this->updateOptionGroup();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
