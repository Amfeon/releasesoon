<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('original');
            $table->string('director');
            $table->string('actors');
            $table->date('date_release');
            $table->date('DVD_release');
            $table->text('plot');
            $table->string('image');
            $table->char('imdb',50);
            $table->char('DVD_source',50);
            $table->string('description');
            $table->char('kinopoisk',50);
            $table->int('rating',1);
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
        Schema::drop('films');
    }
}
