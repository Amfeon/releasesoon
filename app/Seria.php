<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seria extends Model
{
    public function Season(){
        return $this->belongsTo('App\Season','id_season','id');
    }
}
