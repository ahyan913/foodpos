<?php

namespace App\Models\Forms;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class StaffLogin
{

    protected $error = "";

    protected $staff = null;

    protected $username = null;

    protected $password = null;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getError(){
        return $this->error;
    }

    public function getLoginedStaff(){

        return $this->staff;

    }

    public function validate(){
        try{

            if(empty($this->password))
                throw new \Exception(__("Password Incorrect"));

            if(empty($this->username)){
                throw new \Exception(__("Username Incorrect"));
            }
            //$this->staff = $staff;
            return true;

        }catch(\Throwable $t){
            Log::error($t->getMessage());
            $this->error = $t->getMessage();
            return false;
        }
    }

}
