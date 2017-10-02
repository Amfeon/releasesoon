<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\film;
use App\Rating;
use App\Trailer;
use DB;
use App\Http\Controllers\ParseController;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use App\FilmChange;


class FilmController extends Controller
{
    //
    public function pagination(Request $request){
        if(isset($request->start)){
             $start=$request->start;
           // $films= DB::select("select * from films ORDER BY 'release' limit ?,12", [$start]);
            $films=DB::table('films')->where('date_release','>=',Carbon::now()->subWeek(3))->skip($start)->take(12)->orderBy('date_release', 'asc')->get();
            return view('pagination',['films'=>$films]);
        }else{
           return "Что-то пошло не так";
        }

    }
    public function mainPage(film $filmModel){
       $films=DB::table('films')->where('date_release','>=',Carbon::now()->subWeek(3))->take(12)->orderBy('date_release', 'asc')->get();
        //$films=$filmModel->mainPageGet());
        return view('home',['films'=>$films]);
    }
    public function index(film $FilmModel,$id)
    {
        //$film = $FilmModel->getPublishedFilm($id);
        $film=Film::where('id',$id)->first();
        $release=$film->date_release;
        $release=explode('-',$release);
        $date_release['date_release']=$release[2].$this->ToRussia($release[1]).$release[0];
        $release=$film->DVD_release;
        $release=explode('-',$release);
        $date_release['DVD_release']=$release[2].$this->ToRussia($release[1]).$release[0];
        $itunes=$film->itunes;
        $itunes=explode('-',$itunes);
        if($itunes[2]!=0){
            $date_release{'itunes'}=$itunes[2].$this->ToRussia($itunes[1]).$itunes[0];    
        }else{
            $date_release['itunes']=0;
        }
        
        $trailer=Film::find($id)->trailers;
        return view('film',['film' => $film,'trailers'=>$trailer,'date'=>$date_release]);
    }
    public  function create(){
        $this->authorize('admin');
        return view('create');
    }
    /*отправка данных*/
    public function store(Request $request, film $kino, Rating $rating)
    {
        $this->authorize('admin');
        $this->validate($request,[
            'title'=>'required'
        ]);
            if ($request->id!=null) {
                //$kino->updateFilm($request->all(), $request->id);
                $kino = Film::find($request->id);
                $kino->title=$request->title;
                $kino->original=$request->original;
                $kino->image=$request->image;
                $kino->plot=$request->text;
                $kino->imdb=$request->imdb;
                $kino->DVD_release=$request->Blu_ray;
                $kino->date_release=$request->release;
                $kino->itunes=$request->itunes;
                $kino->description=$request->description;
                $kino->DVD_source=$request->dvd_source;
                $kino->kinopoisk=$request->kinopoisk;
                $kino->director=$request->director;
                $kino->actors=$request->actors;
                $trailer=$request->trailer;
                $kino->save();
                if($request->trailer!=''){
                    Trailer::insert([
                        'film_id'=>$request->id,
                        'title'=>$request->trailer_title,
                        'trailer'=>$request->trailer
                    ]);
                }
                if($request->Blu_ray!=$request->Old_Blu_ray){//если даты не равны
                    FilmChange::insert([
                        'film_id'=>$request->id,
                        'Blu_ray'=>1
                    ]);
                }
                return redirect('/admin');
            } else {
                preg_match('~[0-9]{5,}~',$request->kinopoisk,$a);
                $kinopoisk=$a[0];
                preg_match('~tt.[0-9]{1,}~',$request->imdb,$a);
                $imdb=$a[0];
                $id = film::insertGetId(
                    [   'title' => $request->title,
                        'original' => $request->original,
                        'image' => $request->image,
                        'plot' => $request->text,
                        'imdb' => $imdb,
                        'DVD_release' => $request->Blu_ray,
                        'date_release' => $request->release,
                        'itunes' => $request->itunes,
                        'description' => $request->description,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'DVD_source' => $request->DVD_sourсe,
                        'kinopoisk' => $kinopoisk,
                        'director' => $request->director,
                        'actors' => $request->actors,
                    ]);
                Rating::insert([
                    'film_id'=>$id
                ]);
                FilmChange::insert([
                    'film_id'=>$id,
                    'Blu_ray'=>0
                ]);
                if($request->trailer!=''){
                    Trailer::insert([
                        'film_id'=>$id,
                        'title'=>$request->trailer_title,
                        'trailer'=>$request->trailer
                    ]);
                }
                return redirect('/admin');
            }

    }
    /*Отображение формы обновления*/
    public function showUpdate(Request $request,Film $filmModel, ParseController $parse){
        $this->authorize('admin');
        if (isset($request->id)){
            $films=$filmModel->getUpdatedFilm($request->id);
            foreach ($films as $film){
               $DVD_source=$film->DVD_source;
               $imdb_source=$film->imdb;
            }
            if($DVD_source!=null) {
                $Blu_ray2 = $parse->parse_blu_ray($DVD_source);// получаем спарсенную дату
                if ($Blu_ray2 == 0) {
                    $Blu_ray['dvd'] = 'Дата не анонсирована';
                    $Blu_ray['itunes'] = 'Дата не анонсирована';
                }else{
                    $Blu_ray=$Blu_ray2;
                }
            }else{
                $Blu_ray['dvd'] = 'Нет источника';
                $Blu_ray['itunes'] = 'Нет источника';
            }
            /*НАписать проверку новой даты выхода фильма*/
            $release_date=$parse->getReleaseImdb($imdb_source);
                $mass_date=['Blu_ray'=>$Blu_ray['dvd'],'Release_date'=>$release_date, 'itunes'=>$Blu_ray['itunes']];
                return view('updateForm',['films'=>$films, 'mass_date'=>$mass_date]);
            }else{
                $films=$filmModel->getFilm();// создать получение всех записей
                return view('show',['films'=>$films]);
            }
            }
    public function drop(Request $request, film $filmModel, rating $rating ){
        $this->authorize('admin');
        $films=$filmModel->drop($request->id);// создать получение всех записей
        $rating->delete($request->id);
        return redirect('/update');
    }

    public function admin(){
        $this->authorize('admin');
        return view('layouts.admin');
    }

    public function Blu_ray($data=null){
        if($data!=null){
            $mass=explode('-',$data);
            $month=$this->change_date($mass[0]); //месяц в число
            $next_month=$month+1; //следующий месяц
            $next_year=$mass[1]; // следующий год
            if($next_month==13){ // определение Января нового года
                $next_month=1;
                $next_year=$mass[1]+1;
            }
            $next_month=$this->IntToString($next_month);
            //предыдущий месяц
            $prev_month=$month-1;
            $prev_year=$mass[1];
            if ($prev_month==0){
                $prev_month=12;
                $prev_year=$mass[1]-1; //предыдущий год
            }
            $prev_month=$this->IntToString($prev_month);
            $dt=Carbon::now()->month;
            $dy=Carbon::now()->year;
            if ($month==$dt&&$mass[1]==$dy){
                return redirect('/dvd/');
            }
            /* МЕсяц нужно преобразовать в цыфру,а потом сравнить с текущим*/
            $film= DB::select('select * from films where MONTH(DVD_release)=? AND YEAR(DVD_release)=? ORDER BY DVD_release', [$month,$mass[1]]);// нужна проверка успешности запроса

               //  $now='month.'.$mass[0].'';
                 $now=trans('month.'.$mass[0].'');
                 $data=[ 'next'=>''.$next_month.'-'.$next_year,
                         'prev'=>''.$prev_month.'-'.$prev_year,
                         'now'=>''.$now.'-'.$mass[1]
                ];
            if($film==null) {
                return view('empty',['data'=>$data]);
            }else{
                return view('blu_ray',['films'=>$film,'data'=>$data]);
            }

        }else{
            $carbon=Carbon::now()->month; //получаем месяц
            $year=Carbon::now()->year; //получаем текущий год
            $prev_year=$next_year=$year;
            $film= DB::select('select * from films where MONTH(DVD_release)=? AND YEAR(DVD_release)=? ORDER BY DVD_release', [$carbon,$year]);// нужна проверка успешности запроса
            $month=$carbon;
            $next_month=$month+1;
            if($next_month==13){ // определение Января нового года
                $next_month=1;
                $next_year=$year+1;
            }
            $next_month=$this->IntToString($next_month);
            //предыдущий месяц
            $prev_month=$month-1;
            if($prev_month==0){
                $prev_year=$year-1;
                $prev_month=12;
            }
            $prev_month=$this->IntToString($prev_month);
            $now=trans('month.'.$this->IntToString($carbon).'');

            $data=[ 'next'=>''.$next_month.'-'.$next_year,
                    'prev'=>''.$prev_month.'-'.$prev_year,
                    'now'=>''.$now.'-'.$year
            ];
           return view('blu_ray',['films'=>$film,'data'=>$data]);
        }

    }
    public function change_date($data){
        switch ($data){
            case 'January': $data=1;break;
            case 'February': $data=2;break;
            case 'March': $data=3;break;
            case 'April': $data=4;break;
            case 'May': $data=5;break;
            case 'June': $data=6;break;
            case 'July': $data=7;break;
            case 'August': $data=8;break;
            case 'September': $data=9;break;
            case 'October': $data=10;break;
            case 'November': $data=11;break;
            case 'December': $data=12;break;
            default: return 'редирект на 404 ошибку';
        }
        return $data;
    }
    public function IntToString($month){
        switch ($month){
            case 1: $month='January';break;
            case 2: $month='February';break;
            case 3: $month='March';break;
            case 4: $month='April';break;
            case 5: $month='May';break;
            case 6: $month='June';break;
            case 7: $month='July';break;
            case 8: $month='August';break;
            case 9: $month='September';break;
            case 10: $month='October';break;
            case 11: $month='November';break;
            case 12: $month='December';break;
            default: return "ошибка порядкового номера месяца";
        }
        return $month;
    }
    public function ToRussia($month){
        switch ($month){
            case 1: $month=' Января ';break;
            case 2: $month=' Февраля ';break;
            case 3: $month=' Марта ';break;
            case 4: $month=' Апреля ';break;
            case 5: $month=' Мая ';break;
            case 6: $month=' Июня ';break;
            case 7: $month=' Июля ';break;
            case 8: $month=' Августа ';break;
            case 9: $month=' Сентября ';break;
            case 10: $month=' Октября ';break;
            case 11: $month=' Ноября ';break;
            case 12: $month=' Декабря ';break;
            default: return "ошибка порядкового номера месяца";
        }
        return $month;
    }

}

