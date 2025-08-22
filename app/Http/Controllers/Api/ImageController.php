<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helper\ImageHelper;

class ImageController extends Controller
{
    //
    public function execute(Request $request){


        return view('components.test.test');

    }

    public function get(Request $request, String $imageType, String $imagePath){

        try{
            if($file = ImageHelper::getFile($imagePath, $imageType)){
                return response()->file($file);
            }
            return abort(404);
        }catch(\Throwable $t){
            abort(404);
        }
        //return view('components.test.test');

    }
}
