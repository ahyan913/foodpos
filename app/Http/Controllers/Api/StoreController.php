<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Constant\StoreStatus;

class StoreController extends Controller
{
    //
    public function list(){

        $stores = Store::where("status",StoreStatus::ACTIVE)
                    //->with("menus")
                    ->get();

        return response()->json($stores);

    }
}
