<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SerialController extends Controller
{
    public function main(){
        $Serial=DB::table('serias')->where('date','>=',Carbon::now()->subWeek(1))->take(12)->orderBy('date', 'asc')->get();
        //$films=$filmModel->mainPageGet());
        return view('home',['films'=>$Serial]);
    }
}
