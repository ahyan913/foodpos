<?php
namespace App\Models;

use Illuminate\Http\Request;

class AdminSession
{
    const KEY = "logined_staff";

    protected $staff = null;

    public function __construct(Request $request){
        $this->staff = $request->session()->get(self::KEY);
    }

    public function isLogined(){
        return $this->staff != null;
    }

    public function get(){
        return $this->staff;
    }

    public function set(User $staff){
        session([self::KEY=>$staff]);
    }

    public function clear(){
        session()->forget(self::KEY);
    }

}
