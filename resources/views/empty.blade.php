@extends('layouts.basic')
@section('head')
    <meta name="description" content="Здесь вы можете найти дату выхода лицензии ожидаемого вами фильма на Blu-ray и HD.">
    <title>
        График  Blu-ray и HD лицензированных релизов ожидаемых фильмов намеченных на @if(isset($data['now'])) {{$data['now']}} @endif Кинопытка.ru
    </title>
@endsection
@section('menu')
    <li ><a href="{{ url('/') }}">Даты выхода</a></li>
    <li class="{{'active'}}"><a href="{{ url('/blu-ray') }}">Blu-Ray релизы</a></li>
@endsection
@section('content')
    <div class="container ">
        <div class="row">
        <h1 > Blu-ray релизы запланированные на   {{$data['now']}}</h1>
          <p> К сожалению, в этом месяце Blu-ray релизов не запланированно!</p>
        </div>
        <div class="blu_ray_nav" >
            <a  class="left" href="/blu-ray/{{$data['prev']}}"><div >
                    {{$data['prev']}}
                </div></a>
            <a class="right"  href="/blu-ray/{{$data['next']}}">
                <div >
                    {{$data['next']}}
                </div></a>
        </div>
    </div>
@endsection