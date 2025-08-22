<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Forms\StaffLogin;
use App\Models\Forms\StaffForm as StaffForm;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Helper\UrlHelper;


class UserController extends Controller
{
    public function loginPage(Request $request){

        if(!Auth::user()){
            return view('users/login');
        }
        return redirect(UrlHelper::admin('dashboard'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request){

        $username = $request->input("username");
        $password = $request->input("password");

        $form = new StaffLogin($username, $password);

        if($form->validate()){

            if(Auth::attempt(["username"=>$username, "password"=>$password], true)){
                return redirect(UrlHelper::admin("dashboard"));
            }else{
                return redirect()->back()->withErrors(["errors"=>__("User not found. Please check your username or password is valid")]);
            }
        }else{
            return redirect()->back()->withErrors(["errors"=>$form->getError()]);
        }



    }

    public function list(Request $request){
        return view("users.list",[
            "users"=>User::paginate($this->totalPerPage)
        ]);
    }

    public function get(Request $request, \App\Models\User $user){

        $selectedRoleIds = [];

        if($user->id){
            $selectedRoleIds = UserRole::getRoleIdsByStaffId($user->id);
        }

        return view("users.info",[
            "staff"         =>  $user,
            "roles"         =>  Role::all(),
            "selectedRoleIds"      =>  $selectedRoleIds,
            "action"        =>  "/user/".$user->id
        ]);

    }

    public function save(Request $request, \App\Models\User $user){

        $id = "";

        try{
            $roleIds = $request->input("role") ?? [];
            $form = new StaffForm();
            $form->setFormData($request, $user->id);

            $staff = $form->save();
            if(!$staff)
                throw new \Exception($form->getError());

            $id = $staff->id;

            UserRole::updateUserRoleIds($staff->id, $roleIds);

            $request->session()->flash("success", __("Save :name Successfully", ["name"=>__("User")]));

            return redirect("/user/$id");

        }catch(\Throwable $t){
            $request->session()->flash("error", $t->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete(Request $request, User $user){
        $user->delete();
        $request->session()->flash("success", __("Remove :name Successfully", ["name"=>__("User")]));
        return redirect("/users");
    }

    public function logout(Request $request){

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect(UrlHelper::admin("login"));

    }

}
