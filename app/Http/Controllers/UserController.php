<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
//use Intervention\Image\Facades\Image;
use Image;

class UserController extends Controller
{
    public function profile(){
        return view('profile', array('user'=>Auth::user()));
    }
    public function update_avatar(Request $request){
        if ($request->hasFile('avatar')){
            $avatar=$request->file('avatar');
            $file_name=time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(150,150)->save(public_path('/image/avatar/'.$file_name));
            $user=Auth::user();
            $user->avatar=$file_name;
            $user->save();
        }
        return view('profile', array('user'=>Auth::user()));
    }
}
