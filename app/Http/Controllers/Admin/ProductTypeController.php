<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Helper\UrlHelper;
use App\Services\TypeSaveService;

class ProductTypeController extends Controller
{
    protected $title;
    protected $route;


    public function __construct()
    {
        $this->title = __("Food Type");
        $this->route = UrlHelper::adminuri()."/product_type";

    }

    public function list(Request $request){

        //MailHelper::sendTestMail();

        return view("product_type.list",[
            "rows"=>Type::paginate($this->totalPerPage)
        ]);
    }

    public function get(Request $request, Type $productType){

        return view("product_type.info",[
            "model"=>$productType,
            "modelName"=>$this->title,
            "action"=>"/{$this->route}/".$productType->id,
        ]);
    }

    public function save(Request $request, Type $productType){

        $request->validate([
            "name"  =>  'required|max:255',
            "status"   => 'required',
        ]);


        try{
            $service = new TypeSaveService($productType);
            $service
                ->initByRequest($request)
                ->uploadImage()
                ->save();
            $this->success(__("Save :name Successfully", ["name"=>$this->title]));
            return $this->redirect("product_type/".$productType->id);
        }catch(\Throwable $t){
            $this->error($t->getMessage());
            return back()->withInput();
        }
    }

    public function delete(Request $request, Type $productType){

        if($productType->delete())
            $this->success(__("Remove :name Successfully", ["name"=>$this->title]));

        return $this->redirect("product_types");

    }
}
