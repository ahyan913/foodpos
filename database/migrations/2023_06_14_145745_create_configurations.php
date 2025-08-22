<?php

use App\Models\Constant\LocaleStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string("path")->unique("path");
            $table->longText("value");
            $table->timestamps();
        });

        DB::table("configurations")->insert([
            "path"=>"locale_supported",
            "value"=>json_encode(["en_US", "zh_HK"]),
        ]);

        DB::table("configurations")->insert([
            "path"=>"locale_default",
            "value"=>"en_US"
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language');
    }
}
