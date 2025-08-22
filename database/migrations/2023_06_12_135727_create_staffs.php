<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Constant\StaffStatus;
use App\Models\Constant\Gender;
use Illuminate\Support\Facades\Hash;

class CreateStaffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->integer('gender');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->integer('status');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
        });

        DB::table('user')->insert([
            "email"         =>  "admin@example.com",
            "username"      =>  env("DEFAULT_ADMIN"),
            'gender'        =>  Gender::NONDISCLOSURE,
            "first_name"    =>  "Super",
            "last_name"     =>  "Administrator",
            "status"        =>  StaffStatus::ACTIVE,
            "password"      =>  Hash::make(env("DEFAULT_ADMIN_PASSWORD"))
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
