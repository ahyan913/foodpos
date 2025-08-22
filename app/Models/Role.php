<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $table = "role";
    protected $primaryKey = "id";

    public $timestamps = false;

    public $fillable = ["name", "is_super"];

    public function staffs(){
        return $this->belongsToMany(User::class, UserRole::TABLE, "role_id", "staff_id");
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class, RolePermission::TABLE, "role_id","permission_id");
    }

}
