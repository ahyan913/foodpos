<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTimeslots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeslot', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->json("monday");
            $table->json("tuesday");
            $table->json("wednesday");
            $table->json("thursday");
            $table->json("friday");
            $table->json("saturday");
            $table->json("sunday");
            $table->longText("exclude_dates");
            $table->timestamps();
        });

        DB::table("timeslot")->insert([
            "name"=>"預設",
            "monday"=>json_encode(["start_time"=>"10:00","end_time"=>"22:00", "rest_start"=>"16:00", "rest_end"=>"17:30"]),
            "tuesday"=>json_encode(["start_time"=>"10:00","end_time"=>"22:00", "rest_start"=>"16:00", "rest_end"=>"17:30"]),
            "wednesday"=>json_encode(["start_time"=>"10:00","end_time"=>"22:00", "rest_start"=>"16:00", "rest_end"=>"17:30"]),
            "thursday"=>json_encode(["start_time"=>"10:00","end_time"=>"22:00", "rest_start"=>"16:00", "rest_end"=>"17:30"]),
            "friday"=>json_encode(["start_time"=>"10:00","end_time"=>"22:00", "rest_start"=>"16:00", "rest_end"=>"17:30"]),
            "saturday"=>json_encode(["start_time"=>"10:00","end_time"=>"20:00", "rest_start"=>"16:00", "rest_end"=>"17:30"]),
            "sunday"=>json_encode(["start_time"=>"00:00","end_time"=>"00:00", "rest_start"=>"00:00", "rest_end"=>"00:00"]),
            "exclude_dates"=>"[]"

        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeslot');
    }
}
