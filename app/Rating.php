<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function getRating($film_id){
        $rating=DB::table('ratings')->where('film_id',$film_id)->first();
        return $rating;
    }
    public function del($id)
    {
       return DB::table('ratings')->where('film_id',$id)->delete();
    }
    public function showRating($film_id){
        return DB::table('ratings')->where('film_id',$film_id)->first();
    }
    public function updateRating($rating,$pos,$neg,$film_id){
    return DB::update('UPDATE `ratings` SET rating=?, pos=?,neg=? WHERE film_id=?', [$rating,$pos,$neg,$film_id]);
}
    
}
