<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function send(Request $request)
    {

      $data=$request->all();
      //  print_r($data);
        if(preg_match("~(https:\/\/www\.imdb\.com\/title\/).*~", $data['imdbLink'])){
            if($data['kinopoiskLink'] == ''){
                Mail::send('emails.sendFilm', ['data'=>$data], function($message)
                {
                    $message->to('Laserbick@yandex.ru', 'Господину Дмитрию')->subject('Добавление фильма');
                });
            }else{
                if(preg_match("~(https:\/\/www\.kinopoisk\.ru\/film\/).*~", $data['kinopoiskLink'])){
                    Mail::send('emails.sendFilm', ['data'=>$data], function($message)
                    {
                        $message->to('Laserbick@yandex.ru', 'Господину Дмитрию')->subject('Добавление фильма');
                    });
                }
            }
        }else{
            echo "Не правильно введены данные";
        }


    }
}
