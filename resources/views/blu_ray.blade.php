@extends('layouts.basic')
@section('head')
    <meta name="description" content="Здесь вы можете найти дату выхода лицензии ожидаемого вами фильма на DVD, Blu-ray и HD или iTunes.">
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
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- алаптивные верх -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-4528857575775094"
                 data-ad-slot="6307733935"
                 data-ad-format="auto"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            <p>
                В заметках указана дата DVD (HD и Blu-Ray) релиза в Америке, у нас фильмы выходят раньше или так же (данные хрен найдешь, так что сильно не ругайтесь). Довольно часто даты переносятся издателями, так что следите =)
            </p>
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
                            <div class="stripe_down">DVD релиз:<br/> {{$film->DVD_release}}</div>
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