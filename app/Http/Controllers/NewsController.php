<?php

namespace App\Http\Controllers;

use App\FilmChange;
use App\Film;
use Illuminate\Http\Request;

use App\Http\Requests;

class NewsController extends Controller
{
    public function changes_show(){
       // $changes=FilmChange::all();

      // return view('film_changes',['changes'=>$changes]);
       return view('film_changes');
    }

}
