<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Policies\RolePolicy;
use App\Models\Permission;

class AddRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        foreach(["read", "update", "delete", "create"] as $action){        //
            Permission::create([
                "action"        =>  $action,
                "policy"        =>  RolePolicy::class,
                "group"         =>  "Role"
            ]);
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
