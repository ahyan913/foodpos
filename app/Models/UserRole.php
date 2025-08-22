<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    const TABLE = "user_role";

    protected $table = "user_role";

    protected $primaryKey = "id";

    public $timestamps = false;

    public $fillable = ["role_id", "user_id"];


    public static function getRoleIdsByStaffId($userId){
        $roleIds = [];
        if($staffRoles = self::where("user_id", $userId))
            $roleIds = $staffRoles->pluck("role_id")->toArray();
        return $roleIds;
    }

    public static function getStaffIdsByRoleId($roleId){
        $roleIds = [];
        if($staffRoles = self::where("role_id", $roleId))
            $roleIds = $staffRoles->pluck("user_id")->toArray();

        return $roleIds;
    }

    public static function updateUserRoleIds($userId, $roleIds){

        $userRoleIds = self::getRoleIdsByStaffId($userId);
        $insertIds = array_diff($roleIds, $userRoleIds);
        $deleteIds = array_diff($userRoleIds, $roleIds);
        foreach($insertIds as $id){
            self::create([
                "role_id"=>$id,
                "staff_id"=>$userId
            ]);
        }
        if($deleteIds){
            self::where("staff_id",$userId)
                ->whereIn("role_id", $deleteIds)
                ->delete();
        }

    }

}
