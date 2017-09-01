<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::auth();
Route::group(['middleware'=> 'auth'],function(){
    Route::get('admin', 'FilmController@admin');
    Route::get('/create/','FilmController@create');
    Route::get('/edit/{id}','FilmController@edit');
    Route::post('/update/{id}','FilmController@update');
    Route::get('/update','FilmController@showUpdate');
    Route::get('/update/{id}','FilmController@showUpdate');
    Route::get('/delete/{id}','FilmController@delete');
    //Route::post('/store','FilmController@store');
    Route::post('/store/{id?}','FilmController@store');
    Route::get('/show/{id}','FilmController@show');
    Route::get('/delete/{id}','FilmController@drop');
    Route::get('/parse_blu_ray','ParseController@update_Blu_ray'); //обновление DVD релизов
    Route::get('/parse_imdb','ParseController@update_imdb'); // Обновление дат выхода
    Route::get('/parse','ParseController@parse');// поменять на парсер
    Route::get('/parseImage','ParseController@parseImage');// поменять на парсер
});

Route::get('/film/{id}', 'FilmController@index')->where(['id'=>'[0-9]+']);
Route::get('/', 'FilmController@mainPage');
Route::post('/', 'FilmController@pagination');
Route::get('/dvd/{data?}','FilmController@Blu_ray')->where(['data'=>'\w{3,9}\-\d{4}']);
Route::get('/tv','SerialController@main');
Route::post('/rating','RatingController@showRating');
Route::post('/ratingAdd','RatingController@calcRating'); //нужен будет посредник на отправку аякс
Route::get('/news','NewsController@changes_show');
Route::get('/profile','UserController@profile');
Route::post('/profile','UserController@update_avatar');
Route::get('/sitemap.xml','SitemapController@index');
Route::get('/search', function (){
    return view('search');
});


/*Route::get('/create',['middleware'=> 'auth'
    ,'uses'=>'FilmController@create']);*/

//Route::post('/store','FilmController@store');






/*Route::post('/rating', function (){
    if(Request::ajax()){
        return Request::all();
    }
});*/
//Route:: post('rating','Rating@add');