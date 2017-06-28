<!-- show.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container">
        <ul class="row">
            @foreach($films as $film)
                <li><a class="col-md-6" href="/update/{{$film->id}}">{{$film->title}}</a><a href="/delete/{{$film->id}}"  alt="Удалить"><button class="btn-danger col-md-6">delete</button>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
