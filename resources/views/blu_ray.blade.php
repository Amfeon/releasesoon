@extends('layouts.basic')
@section('head')
    <meta name="description" content="Дата выхода лицензии ожидаемого вами фильма на DVD, Blu-ray и HD или iTunes, которые запланированы на {{$data['now']}}" >
    <title>
            Расписание DVD, Blu-ray и HD лицензированных релизов ожидаемых фильмов намеченных на @if(isset($data['now'])) {{$data['now']}} @endif Скоро-Выход.ru
    </title>
@endsection
@section('menu')
    <li ><a href="{{ url('/') }}">Даты выхода</a></li>
    <li class="{{'active'}}"><a href="{{ url('/DVD') }}">Blu-Ray релизы</a></li>
    <li><a href="{{ url('/release-changes') }}">Новости релизов</a></li>
@endsection
@section('content')
    <main class="container">
        <div class="row">
            <h1 class=" alert alert-info"> DVD релизы запланированные на   {{$data['now']}}</h1>
            <p>
                В заметках указана дата DVD (HD и Blu-Ray) релиза в Америке, у нас фильмы выходят раньше или так же (данные хрен найдешь, так что сильно не ругайтесь). Довольно часто даты переносятся издателями, так что следите =)
            </p>
        </div>
        <div class="row">
            <div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir"></div>
        </div>
        <div class="row">
            <ul id='scroll' >
                @foreach($films as $film)
                    <li>
                        <div class='poster'>
                            <div class="stripe_up">
                                {{$film->title}}
                            </div>
                            <a href='/film/{{$film->id}}'>
                                <img  width="150" height="250" src ='/{{$film->image}}' alt='Подробенее о фильме {{$film->title}}' title='Подробенее о фильме {{$film->title}}'/>
                            </a>
                            <div class="stripe_down">DVD релиз:<br/> {{@date('d-m-Y', strtotime($film->DVD_release))}}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="blu_ray_nav">
            <a class="left" href="/dvd/{{$data['prev']}}">
                <div >
                {{$data['prev']}}
                 </div>
            </a>
            <a class="right" href="/dvd/{{$data['next']}}">
            <div >
                {{$data['next']}}
            </div></a>
        </div>

    </main>
@endsection