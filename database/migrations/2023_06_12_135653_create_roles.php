<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('role')) {
            Schema::create('role', function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->integer('is_super');
                $table->timestamp('created_at')->useCurrent();
            });
        }

        DB::table('role')->insert([
            "name"=>'Super administrator',
            "is_super"=>1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            Schema::dropIfExists('role');
        }catch(\Throwable $t){}
    }
}
