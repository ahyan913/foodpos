<?php
namespace App\Models\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StaffForm{

    protected $username;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $password;
    protected $gender;
    protected $status;
    protected $roles;
    protected $id;
    protected $error = "";

    public function setFormData(Request $request, $id = null){

        $this->username = $request->input("username");
        $this->password = $request->input("password");
        $this->firstName = $request->input("first_name");
        $this->lastName = $request->input("last_name");
        $this->email = $request->input("email");
        $this->password = $request->input("password");
        $this->gender = $request->input("gender");
        $this->roles = $request->input("roles");
        $this->status = $request->input("status");
        $this->id = $id;

    }

    public function getError(){

        return $this->error;

    }

    public function validate(){

        try{
            if(empty($this->firstName))
                throw new \Exception(__(":name cannot be empty", ["name"=>__("First Name")]));

            if(empty($this->lastName))
                throw new \Exception(__(":name cannot be empty", ["name"=>__("Last Name")]));

            if(empty($this->username))
                throw new \Exception(__(":name cannot be empty", ["name"=>__("Username")]));

            if(empty($this->email))
                throw new \Exception(__(":name cannot be empty", ["name"=>__("Email")]));

            if(!$this->id){
                if(empty($this->password))
                    throw new \Exception(__(":name cannot be empty", ["name"=>__("Password")]));

            }else{
                if(!User::find($this->id))
                    throw new \Exception(__(":name does not existed", ["name"=>__("Staff")]));
            }

            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
                throw new \Exception(__(":name format is invalid", ["name"=>__("Email Address")]));


            if($staff = User::where("email", $this->email)->first()){
                if(($this->id != $staff->id) || !$this->id)
                    throw new \Exception(__(":name is already existed", ["name"=>__("Email Address")]));
            }

            if($staff = User::where("username", $this->username)->first()){
                if(($this->id != $staff->id) || !$this->id)
                    throw new \Exception(__(":name is already existed", ["name"=>__("Username")]));
            }

            return true;

        }catch(\Throwable $t){
            $this->error = $t->getMessage();
            return false;
        }

    }

    public function save(){

        if($this->validate()){

            if($this->id){
                return $this->update();
            }else{
                return $this->register();
            }
        }else{
            return null;
        }
    }

    protected function update(){
        $staff = User::find($this->id);
        $staff->first_name = $this->firstName;
        $staff->last_name = $this->lastName;
        $staff->status = $this->status;
        $staff->email = $this->email;
        $staff->gender = $this->gender;

        if($this->password){
            $staff->password = Hash::make($this->password);
        }
        $staff->save();

        return $staff;

    }

    protected function register(){


        $data = [
            "email"         =>  $this->email,
            "first_name"    =>  $this->firstName,
            "last_name"     =>  $this->lastName,
            "username"      =>  $this->username,
            "gender"        =>  $this->gender,
            "status"        =>  $this->status,
            "password"      =>  Hash::make($this->password)
        ];

        return User::create($data);

    }

}
