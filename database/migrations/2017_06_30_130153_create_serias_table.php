<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serias', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('id_season');
            $table->integer('number_seas');
            $table->string('title');
            $table->integer('number_seria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('serias');
    }
}
