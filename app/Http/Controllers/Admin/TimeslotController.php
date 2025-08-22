<?php

namespace App\Http\Controllers\Admin;

use App\Models\Timeslot;
use Illuminate\Http\Request;
use App\Helper\MailHelper;
use App\Helper\TimeHelper;
use App\Helper\UrlHelper;

class TimeslotController extends Controller
{
    protected $title;
    protected $route;

    public function __construct()
    {
        $this->title = __("Timeslot");
        $this->route = UrlHelper::adminuri()."/timeslot";
    }

    public function list(Request $request){

        //MailHelper::sendTestMail();

        return view("timeslots.list",[
            "rows"=>Timeslot::paginate($this->totalPerPage),
            "model"=>Timeslot::class,
            "fields"=>[
                "name"=>__("Name"),
                "created_at"=>"Created At"
            ],
            "action"=>"timeslot"
        ]);
    }

    public function get(Request $request, Timeslot $timeslot){

        return view("timeslots.info",[
            "model"=>$timeslot,
            "modelName"=>__(basename(Timeslot::class)),
            "action"=>"/{$this->route}/".$timeslot->id,
        ]);
    }

    public function save(Request $request, Timeslot $timeslot){

        $request->validate([
            "name"  =>  'required|max:2'
        ]);

        $id = "";
        try{

            $monday = $request->input("monday") ?? [];
            $tuesday = $request->input("tuesday") ?? [];
            $wednesday = $request->input("wednesday") ?? [];
            $thursday = $request->input("thursday") ?? [];
            $friday = $request->input("friday") ?? [];
            $saturday = $request->input("saturday") ?? [];
            $sunday = $request->input("sunday") ?? [];
            $name = $request->input("name");
            $excludeDates = $request->input("excluded_dates");

            $timeslot->monday = json_encode($monday);
            $timeslot->tuesday = json_encode($tuesday);
            $timeslot->wednesday = json_encode($wednesday);
            $timeslot->thursday = json_encode($thursday);
            $timeslot->friday = json_encode($friday);
            $timeslot->saturday = json_encode($saturday);
            $timeslot->sunday = json_encode($sunday);
            $timeslot->name = $name;

            if($excludeDates){
                try{
                    $timeslot->exclude_dates = json_encode(explode(",", $excludeDates));
                }catch(\Exception $e){
                    $timeslot->exclude_dates = "[]";
                }
            }else{
                $timeslot->exclude_dates = "[]";
            }

            $timeslot->save();

            $id = $timeslot->id;
            // $isSuper = $request->input("");
            // $permissions = $request->input("permissions");

            // $model->name=$name;
            // $model->is_super = $isSuper ? 1:0;
            // $model->save();
            // $id = $model->id;

            // if($permissions){

            //     RolePermission::where("role_id", $role->id)->delete();
            //     foreach($permissions as $permissionId){
            //         RolePermission::create([
            //             "role_id"=>$role->id,
            //             "permission_id"=>$permissionId,
            //             "created_at"=>date("Y-m-d H:i:s")
            //         ]);
            //     }
            // }

            $this->success(__("Save :name Successfully", ["name"=>$this->title]));

        }catch(\Throwable $t){
            $this->error($t->getMessage());
        }

        return redirect("/timeslot/$id")->withInput();

    }

    public function delete(Request $request, Timeslot $timeslot){

        if($timeslot->delete())
            $this->success(__("Remove :name Successfully", ["name"=>$this->title]));

        return redirect("/timeslots");

    }
}
