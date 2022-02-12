<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('man_categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->char("translation_lang");
            $table->integer("translation_of")->unsigned();
            $table->tinyInteger("active")->default(1)->comment("0 =>nonactive , 1 =>active");
            $table->char("photo")->nullable();
            $table->string("slug");
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
        Schema::dropIfExists('man_categories');
    }
}
