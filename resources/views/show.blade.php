<!-- show.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row search_movie">
            <label for="search">Поиск фильма</label><br/>
            <input role="search" type="text" size="60" >
        </div>
        <ul class="row showUpdate">
            @foreach($films as $film)
                <li>
                    <a class="col-md-6" href="/update/{{$film->id}}">{{$film->title}}</a>
                    <a class="red-btn col-md-4" href="/delete/{{$film->id}}"  alt="Удалить">Удалить</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
