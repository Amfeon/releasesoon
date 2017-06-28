<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use App\Http\Requests;

class RatingController extends Controller
{
    public function calcRating (Request $request, Rating $rating){
          //добываем текущие оценки
          $pos=$request->positiv;
          $neg=$request->negativ;
         $film_id= $request->id;
          $result=$rating->getRating($request->id);
          $pos = $pos + $result->pos; //позитивные оценки
          $neg = $neg + $result->neg; // отрицательыне
          $n= $pos+$neg; 		//общее число оценок
          $part = $pos/$n; 	//доля положительных оценок
          $z=1.64485; //какой то там коэффициент вероятности
          $rating_temp=($part+$z*$z/(2*$n)-$z*sqrt(($part*(1-$part)+$z*$z/(4*$n))/$n))/(1+$z*$z/$n);
          $rating->updateRating($rating_temp,$pos,$neg,$film_id);
        $RatingInfo=$rating->showRating($request->id);
        return view('rating.rating',['RatingInfo'=>$RatingInfo]);
    }
    public function showRating (Request $request, Rating $rating){
       $RatingInfo=$rating->showRating($request->id);
       return view('rating.rating',['RatingInfo'=>$RatingInfo]);
    }
    public function delete($id, Rating $rating){
       $rating->delete($id);
    }
}
