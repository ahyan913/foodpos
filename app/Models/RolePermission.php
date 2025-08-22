<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    const TABLE = "role_permission";
    protected $table = "role_permission";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ["role_id","permission_id"];

}
