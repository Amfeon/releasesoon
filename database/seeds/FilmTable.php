<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FilmTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('films')->insert([
            'title' => str_random(30),
            'image' => 'http://releasesoon.ru/image/secret_life.jpg',
            'original'=>str_random(10),
            'imdb'=>'http://www.imdb.com/title/tt2386490/?ref_=rvi_tt',
            'mojo'=>'http://www.imdb.com/title/tt2386490/?ref_=rvi_tt',
            'DVD_source'=>'Источник',
            'Blu_ray'=>DB::raw('NOW()'),
            'release'=>DB::raw('NOW()'),
            'created_at'=>DB::raw('NOW()'),
            'description'=>str_random(30),
        ]);
    }
}
