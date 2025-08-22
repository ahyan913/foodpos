<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Configuration;
use App\Models\Constant\StoreStatus;
use App\Models\Constant\TableStatus;
use App\Models\Timeslot;
use Image;
use App\Models\Menu;
use App\Models\StoreToMenu;
use App\Models\Table;

class StoreController extends Controller
{

    public $imagePath = null;

    public function __construct()
    {
        $this->imagePath = public_path("images/store/");
    }

    public function list(Request $request){
        return view("stores.list",[
            "rows"=>Store::paginate($this->totalPerPage)
        ]);
    }

    public function get(Request $request, Store $store){

        $storeMenuIds = $store->getMenuIds();

        return view("stores.info",[
            "store"=>$store,
            "storeMenuIds"=>$storeMenuIds,
            "action"=>"/store/".$store->id,
            "menus" => Menu::all(),
            "timeslots"=>Timeslot::all()
        ]);
    }

    public function save(Request $request, Store $store){
        $id = "";

        $request->validate([
            "name"      => "max:255|required",
            "code"      => "required|unique:store,code,$store->id|alpha_num",
            "capacity"  => "required|numeric",
            "latitude"  => "required|numeric",
            "longitude"  => "required|numeric",
            "status"  => "required|numeric",
            "opening_hours"  => "required|numeric",
            "phone"     =>  "required"
        ]);

        try{
            $store->name = $request->input("name");
            $store->code = $request->input("code");
            $store->capacity = $request->input("capacity");
            $store->latitude = $request->input("latitude");
            $store->longitude = $request->input("longitude");
            $store->status = $request->input("status");
            $store->phone = $request->input("phone");
            $store->opening_hours = $request->input("opening_hours");


            if($image = $request->file("image")){
                $store->removeImages();
                $fileName = time();
                $extension = $request->image->extension();
                $imageName = "$fileName.$extension";
                if(!is_dir($store->getImagePath()))
                    mkdir($store->getImagePath());
                $img = Image::make($request->file("image")->path());
                $request->image->move($store->getImagePath(), $imageName);
                $store->image = $imageName;
                $img->resize(100, 100, function($constraint) {
                    $constraint->aspectRatio();
                })->save($store->getImagePath($store->getThumbnail()));

            }

            if($locale = $request->input("locale"))
                $store->locale = $locale;

            $store->save();
            $id = $store->id;

            if($menuIds = $request->input("menu_id"))
                StoreToMenu::updateStoreMenuIds($store->id, $menuIds);



            $tables = $request->input("tables");
            $tableIds = [];

            if(
                $tables
                && is_array($tables)
            ){
                foreach($tables['name'] as $index => $row){
                    $tableId = isset($tables['id'][$index]) && !empty($tables['id'][$index]) ? $tables['id'][$index] : null;
                    $table = new Table();
                    $table->status = TableStatus::ACTIVE;
                    if($tableId){
                        if($_table = Table::find($tableId)){
                            $table = $_table;
                        }
                    }
                    $table->name = isset($tables['name'][$index]) && !empty($tables['name'][$index]) ? $tables['name'][$index] : null;
                    $table->num_of_customers = isset($tables['num_of_customer'][$index]) && !empty($tables['num_of_customer'][$index]) ? $tables['num_of_customer'][$index] : null;
                    $table->store_id = $store->id;
                    $table->save();
                    $tableIds[] = $table->id;
                }
            }

            Table::whereNotIn("id", $tableIds)->where("store_id", $store->id)->delete();

            $this->success(__("Save :name Successfully", ["name"=>__("Store")]));

        }catch(\Throwable $t){
            $this->error($t->getMessage());
        }

        return redirect("/administrator/store/$id")->withInput();

    }

    public function delete(Request $request, Store $store){

        if($store->delete())
            $this->success(__("Remove :name Successfully", ["name"=>__("Store")]));

        return redirect("/administrator/stores");

    }



}
