<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use App\Policies\UserPolicy;

class AddUserPermissions extends Migration
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
                "action"      =>  $action,
                "policy"    =>  UserPolicy::class,
                "group"     =>  "User"
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
