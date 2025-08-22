<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("code")->unique("code");
            $table->boolean("status");
            $table->string("phone");
            $table->string("image");
            $table->decimal("latitude", 14, 10);
            $table->decimal("longitude", 14, 10);
            $table->integer("capacity");
            $table->integer("opening_hours");
            $table->json("locale");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store');
    }
}
