<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStaffRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->biginteger("user_id")->unsigned();
            $table->biginteger("role_id")->unsigned();
            $table->foreign('role_id')->references('id')->on("role")->onDelete("cascade");
            $table->foreign('user_id')->references('id')->on("user")->onDelete("cascade");
        });

        DB::table('user_role')->insert([
            "user_id"=>1,
            "role_id"=>1
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
