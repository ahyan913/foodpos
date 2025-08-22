<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use QrCode;

class CustomerController extends Controller
{
    public function show(){

        var_dump("here");

    }

    public function index(){
        var_dump("index");
    }

    public function update(){
        var_dump("update");
    }

    public function destroy(){
        var_dump("destory");
    }

    public function store(){
        var_dump("store");
    }
}
