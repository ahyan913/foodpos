<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Services\OptionSaveService;

use Exception;

class OptionController extends Controller
{
    protected $title = "";
    protected $imagePath = "images/product";

    public function __construct(){
        $this->title = __("Options");
    }

    public function get(Request $requst, OptionGroup $option)
    {

        return view("components.product.option.info",[
            'model'=>$option,
            'options'=>OptionGroup::all(),
            'products'=>Product::all()
        ]);
    }
    public function list(Request $requst)
    {
        return view("components.product.option.list", [
            "rows"=>OptionGroup::paginate(),
            "model"=>new OptionGroup(),
            "fields"=>[
                "id"=>__("ID"),
                "name"=>__("Name"),
            ],
            "action"=>"option",
        ]);
    }

    public function delete(Request $requst, OptionGroup $option)
    {
        if($option->delete())
            $this->success(__("Remove :name Successfully", ["name"=>$this->title]));

        return redirect(admin_url("options"));
    }

    public function save(Request $request, OptionGroup $option)
    {
        $request->validate([
            "name"=>"required|max:255",
        ]);

        try{
            $service = new OptionSaveService($option);
            $service
                ->setByRequest($request)
                ->save();

            $this->success(__("Save :name Successfully", ["name"=>$this->title]));

        }catch(\Throwable $t){
        //    echo $t;
            $this->error($t->getMessage());
        }

        return redirect(admin_url("option/".$option->id));
    }

}
