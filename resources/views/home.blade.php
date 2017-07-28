@extends('layouts.basic')
@section('head')
    <meta name="description" content="Здесь вы можете найти дату выхода лицензии ожидаемого вами фильма, а так же дату DVD релиза">
    <title>
        График выхода фильмов в кино, Blu-ray и HD лицензированных релизов ожидаемых фильмов на Скоро-Выход.ru
    </title>
@endsection
@section('content')
    <div id="page-preloader" class="preloader">
        <div class="loader">

        </div>
    </div>
        <main class="container">
            <div class="row">
                <h1>Расписание выхода наиболее ожидаемых фильмов в России </h1>
                <p>
                    В заметках указаны даты выхода фильмов на территории матушки России, в некоторых местах, дата может отличаться на плюс минус день
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
                                <a href='film/{{$film->id}}'>
                                    <img  width="150" height="250" src ='{{$film->image}}' alt='Подробнее о фильме {{$film->title}}' title='Подробнее о фильме {{$film->title}}'/>
                                </a>
                                <div class="stripe_down">Дата Выхода:<br/> {{@date('d-m-Y', strtotime($film->date_release))}}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div id="more" class="more_scroll">
                <p>
                    Показать еще
                </p>
            </div>
        </main>

@endsection
@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
</script>
<script type="text/javascript">
 /*   document.body.onload = function () {
        setTimeout(function () {
            var preloader = document.getElementById('page-preloader');
            if(!preloader.classList.contains('done')){
                preloader.classList.add('done');
            }
        },100)
    }*/
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var start=12;
        $("#more").click(function () {
                $('#page-preloader').fadeIn();
            var btn = $(this)
            btn.text('loading...')
            $.ajax({
                url: "/", // url запроса
                cache: false,
                data: { start: start }, // если нужно передать какие-то данные
                type: "POST", // устанавливаем типа запроса POST
                success: function(html) {
                    if(html==0){
                        $("#more").hide();
                    }else {
                        //console.log(html);
                        start=start+12;
                        $('#scroll').append(html);

                    }
                    $('#page-preloader').fadeOut();
                } //контент подгружается в div#content
            }).always(function () {
                btn.text('Показать еще')
            });
            return false
        })
    });
</script>
@endsection
