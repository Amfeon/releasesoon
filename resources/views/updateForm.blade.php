@extends('layouts.admin')
@section('content')
    <div class="container">
        @foreach($films as $film)
        <form class="form-horizontal" method="POST" action='/store/{{$film->id}}'>

            <label class="control-label">imdb</label>
            <div  id="parse" class="btn btn-warning">Спарсить</div>
            <a target="_blank"  href="http://www.imdb.com/title/{{$film->imdb}}"><div class="btn btn-info">Перейти на сайт</div></a>
            <div class="row alert alert-info">
                <label>Дата Blu_ray: </label>{{$mass_date['Blu_ray']}}<br/>
                <label>Дата Выхода: </label>{{$mass_date['Release_date']}}<br/>
            </div>
            <input type="text" class="form-control"  name="imdb" value="{{$film->imdb}}">

            <label class="control-label">Kinopoisk</label>
            <input type="text" class="form-control"  name="kinopoisk" value="{{$film->kinopoisk}}">

            <label class="control-label">Источник DVD</label>
            <input type="text" class="form-control" name="dvd_source" value="{{$film->DVD_source}}">

            <label class="control-label">Название фильма</label>
            <input type="text" class="form-control"  name="title" value="{{$film->title}}">

            <label class="control-label">Оригинальное</label>
            <input type="text" class="form-control"  name="original" value="{{$film->original}}">

            <label class="control-label">Описание</label>
            <input type="text" class="form-control"  name="description" value="{{$film->description}}">

            <label class="control-label">Актеры</label>
            <input type="text" class="form-control"  name="actors" value="{{$film->actors}}">

            <label class="control-label">Директор</label>
            <input type="text" class="form-control"  name="director" value="{{$film->director}}">

            <label class="control-label">Дата выхода</label>
            <input type="text" class="form-control"  name="release" value="{{$film->date_release}}">
            <input type="hidden" name="Old_release" value="{{$film->date_release}}">
            <label class="control-label">Блю-рей релиз</label>
            <input type="text" class="form-control"  name="Blu_ray" value="{{$film->DVD_release}}">
            <input type="hidden" name="Old_Blu_ray" value="{{$film->DVD_release}}">
            <label class="control-label">Картинка</label>
            <input type="text" class="form-control"  name="image" value="{{$film->image}}">

            <label class="control-label">Трейлер Заголовок</label>
            <input type="text" class="form-control"  name="trailer_title" >
            <label class="control-label">Трейлер код</label>
            <input type="text" class="form-control"  name="trailer" >
            <label class="control-label">Сюжет фильма</label>
            <textarea class="form-control" id="text" name="text">{{$film->plot}}</textarea>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input class="btn btn-primary" type="submit" value="обновить">

        </form>
@endforeach
    </div>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code',
                'spellchecker'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image |spellchecker ',
            content_css: [
                '//www.tinymce.com/css/codepen.min.css'
            ],
            // Spellchecker
            spellchecker_languages: "Russian=ru,Ukrainian=uk,English=en",
            spellchecker_language: "ru",  // default language
            spellchecker_rpc_url: "http://speller.yandex.net/services/tinyspell"
        });</script>


@endsection