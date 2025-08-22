<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Helper\UrlHelper;

class RoleController extends Controller
{
    public function list(Request $request){

        return view("roles.list",[
            "rows"=>Role::paginate($this->totalPerPage)
        ]);
    }

    public function get(Request $request, Role $role){

        $permissions = [];
        $checkedPermissions = [];

        foreach(Permission::all() as $row){

            if(!isset($permissions[$row['group']])){
                $permissions[$row['group']] = [];
            }
            $permissions[$row['group']][] = $row;
        }

        foreach($role->permissions as $permission){
            $checkedPermissions[] = $permission->id;
        }


        return view("roles.info",[
            "role"=>$role,
            "checked"=>$checkedPermissions,
            "permissions"=> $permissions,
            "action"=>"/role/".$role->id,
        ]);
    }

    public function save(Request $request, Role $role){
        $id = "";
        try{

            $name = $request->input("name");
            $isSuper = $request->input("is_super");
            $permissions = $request->input("permissions");

            if(!$role){
                $isUpdate = false;
                $role = new Role();
            }

            $role->name=$name;
            $role->is_super = $isSuper ? 1:0;
            $role->save();
            $id = $role->id;


            if($permissions){
                RolePermission::where("role_id", $role->id)->delete();
                foreach($permissions as $permissionId){
                    RolePermission::create([
                        "role_id"=>$role->id,
                        "permission_id"=>$permissionId,
                        "created_at"=>date("Y-m-d H:i:s")
                    ]);
                }
            }

            $this->success(__("Save :name Successfully", ["name"=>__("Role")]));

        }catch(\Throwable $t){
            $this->error($t->getMessage());
        }

        return redirect(UrlHelper::adminuri()."/role/$id");

    }

    public function delete(Request $request, Role $role){

        if($role->delete())
            $this->success(__("Remove :name Successfully", ["name"=>__("Role")]));

        return redirect("/roles");

    }

}
