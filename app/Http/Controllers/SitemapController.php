<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\film;
use App\Http\Requests;

class SitemapController extends Controller
{
    //
    public function index(){
        $films=Film::orderBy('release', 'asc')->get();
        return view('layouts.sitemap',['films'=>$films]);
    }

}
