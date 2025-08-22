<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OptionGroup;
use App\Services\ProductSaveService;
use App\Models\Type;

class ProductController extends Controller
{
    protected $title = "";
    protected $imagePath = "";

    public function __construct(){
        $this->title = __("Products");
    }

    public function get(Request $requst, Product $product)
    {
        $model = $product;

        return view("components.product.info",[
            "model"=>$model,
            "productTypes"=>Type::all(),
            "optionGroups"=>OptionGroup::with(["productoptions","options", "productoptions.product"])->get()
        ]);
    }
    public function list(Request $requst)
    {
        return view("components.product.list",[
            "rows"=>Product::paginate($this->totalPerPage),

        ]);
    }

    public function delete(Request $requst, Product $model)
    {
        if($model->delete())
            $this->success(__("Remove :name Successfully", ["name"=>$this->title]));

        return $this->redirect("products");
    }

    public function save(Request $request, Product $product)
    {
        $id = null;

        $request->validate([
            "name"=>"required|max:255",
            //"sku"=>"required|max:255",
            "image"=>"image",
            "price"=>"required|numeric",
            "status"=>"required|numeric",
        ]);

        try{

            $service = new ProductSaveService();
            $service
                ->initByRequest($request, $product)
                ->save();
            $this->success(__("Save :name Successfully", ["name"=>$this->title]));

            return $this->redirect("product/".$product->id);

        }catch(\Throwable $t){
            $this->error($t->getMessage());
        }
        return back()->withInput();
    }
}
