<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("price")->unsigned();
            $table->boolean("status")->default(0);
            $table->string("image");
            $table->date("schedules")->nullable();
            $table->longText("locale");
            $table->timestamps();
        });

        Schema::create('type',function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->integer("status")->default(0);
            $table->string("image")->nullable();
            $table->longText("locale");
            $table->timestamps();
        });

        Schema::create('type_product',function (Blueprint $table) {
            $table->id();
            $table->bigInteger("type_id")->unsigned();
            $table->bigInteger("product_id")->unsigned();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on("product")->onDelete("cascade");
            $table->foreign('type_id')->references('id')->on("type")->onDelete("cascade");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schemas = ["type_product", "type",
        //"product_attributes",
        "product"];

        foreach($schemas as $s){
            Schema::dropIfExists($s);
        }

    }
}
