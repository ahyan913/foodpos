<?php

namespace App\Http\Controllers\Admin;

use App\Helper\UrlHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $totalPerPage = 20;

    public function success($msg){
        session()->flash("success", $msg);
    }

    public function error($msg){
        session()->flash("error", $msg);
    }

    public function redirect($path = "/"){
        return redirect(UrlHelper::admin(($path)));
    }
}
