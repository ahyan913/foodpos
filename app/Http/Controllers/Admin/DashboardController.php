<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AdminSession;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function execute(Request $request){
        return view('dashboard/index');
    }
}
