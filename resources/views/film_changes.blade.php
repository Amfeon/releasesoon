@extends('layouts.basic')
@section('head')
        <meta name="description" content="Здесь публикуются изменение Blu-ray релизов и дат выхода фильмов">
        <title>
            Изменения в датах выхода фильмов и Blu-ray релизов.
        </title>

@endsection
@section('menu')
    <li ><a href="{{ url('/') }}">Даты выхода</a></li>
    <li ><a href="{{ url('/blu-ray') }}">Blu-Ray релизы</a></li>
    <li class="{{'active'}}"><a href="{{ url('/release-changes') }}">Новости релизов</a></li>
@endsection
@section('content')
    <main class="container">
        <div class="row">
            <h1>Изменения в датах выхода фильмов и Blu-ray релизов. </h1>
            <p>
                Публикуются даты  ОФИЦИАЛЬНЫХ Blu-ray релизов, никаких пираток и прочей ереси. Данные с оффициальных сайтов.
            </p>
        </div>
        <div class="row">
           <div class="news_title">
               Доктор Стрэндж  / Doctor Strange
           </div>
            <div class="news_date">
                фильм выходит 04-11-2016
            </div>
        </div>
        <div class="row">
            <div class="news_title">
                Доктор Стрэндж  / Doctor Strange
            </div>
            <div class="news_date">
                blu-ray выходит 04-11-2016
            </div>
        </div>
    </main>

@endsection