<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index(){
        return view("web::index");
    }
}
