<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;

class ConfigurationsController extends Controller
{
    public function get(Request $request){

        $configs = [];

        foreach(Configuration::all() as $conf){
            $configs[$conf->path] = $conf->getValue();
        }

        return view("system.configurations", [
            "configs"   =>  $configs
        ]);

    }

    public function save(Request $request){


        if(!isset($_POST['debug_log']) || empty($_POST['debug_log'])){
            $_POST['debug_log'] = 0;
        }

        foreach($_POST as $path => $value){
            if(in_array($path, ["_method", "_token"]))
                continue;

            if(is_array($value))
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            DB::table("configurations")->updateOrInsert(["path"=>$path], ["value"=>$value]);
        };

        $request->session("success", __("Save :name Successfully", ["name"=>__("Configuration")]));

        return back();

    }


}
