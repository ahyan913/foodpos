<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable("role_permission")){
            Schema::create('role_permission', function (Blueprint $table) {
                $table->id();
                $table->biginteger("role_id")->unsigned();
                $table->biginteger("permission_id")->unsigned();
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('role_id')->references("id")->on('role')->onDelete("cascade");
                $table->foreign('permission_id')->references("id")->on('permission')->onDelete("cascade");

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
}
