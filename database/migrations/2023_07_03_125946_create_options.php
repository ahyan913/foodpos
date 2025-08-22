<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constant\Status;
use App\Models\Constant\OptionType;

class CreateOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('option_groups', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->json("locale");
            $table->tinyInteger("limit")->nullable()->comment("Allow number of selection");
            $table->tinyInteger("type")->default(OptionType::NORMAL)->unsigned();
            $table->tinyInteger("status")->default(Status::ACTIVE)->unsigned();
            $table->integer("sort_order")->default(1)->unsigned();
            $table->timestamps();
        });

        Schema::create("product_option_groups", function(Blueprint $table ){
            $table->biginteger("product_id")->unsigned();
            $table->biginteger("option_group_id")->unsigned();
            $table->integer("sort_order")->default(1)->unsigned();
            $table->timestamps();
            $table->foreign("option_group_id")->references("id")->on("option_groups")->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("product")->onDelete("cascade");
        });

        Schema::create('options',function(Blueprint $table){

            $table->comment("Options under option groups");
            $table->id();
            $table->biginteger("option_group_id")->unsigned();
            $table->json("locale")->nullable();
            $table->float("price")->nullable()->default(0);
            $table->tinyInteger("status")->nullable()->default(Status::ACTIVE);
            $table->integer("sort_order")->default(1);
            $table->timestamps();
            $table->foreign("option_group_id")->references("id")->on("option_groups")->onDelete("cascade");
        });

        Schema::create("product_options", function(Blueprint $table){
            $table->comment("Options under option groups and those are selection related to a product e.g. select drinks as group, lemon tea, milk tea ... etc");
            $table->id();
            $table->biginteger("option_group_id")->unsigned();
            $table->biginteger("product_id")->unsigned();
            $table->float("price")->nullable()->default(0)->comment("if this value is empty, it will load the original product prices");
            $table->tinyInteger("status")->nullable()->default(Status::ACTIVE)->comment("if this value is empty, it will load the original product prices");
            $table->tinyInteger("sort_order")->default(1);
            $table->timestamps();
            $table->foreign("option_group_id")->references("id")->on("option_groups")->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("product")->onDelete("cascade");
        });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        foreach(["option_group_products", "options", "option_groups"] as $schema){
            Schema::dropIfExists($schema);
        }

        //Schema::dropIfExists('options');
    }
}
