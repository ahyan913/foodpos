<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->integer("number")->unsigned();
            $table->bigInteger("store_id")->unsigned();
            $table->tinyInteger("status")->unsigned();
            $table->tinyInteger("num_of_customers")->default(1)->unsigned();
            $table->json("data")->nullable(true);
            $table->timestamps();
            $table->foreign("store_id")->references("id")->on("store")->onDelete("cascade");
            $table->unique(["number", "store_id"]);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
