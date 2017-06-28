<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css" type="text/css"/>
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Выпадающее меню</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Kinopitka.ru
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li ><a href="{{ url('/') }}">Даты выхода</a></li>
                    <li class="{{'active'}}"><a href="{{ url('/blu-ray') }}">Blu-Ray релизы</a></li>
                    <li><a href="{{ url('/release-news') }}">Новости релизов</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Логин</a></li>
                        <li><a href="{{ url('/register') }}">Регистриция</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">

                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выйти</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="../js/jquery.cookie.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    @if(isset($film->id))
    <script>
            $.ajax({
                type: 'post',
                url: '/rating',
                data: {id:{{$film->id}}},
                success: function (html) {
                    //console.log(html);
                    $("#rating").html(html);
                    $("#negativ").data({'negativ': 1, 'positiv': 0});
                    $("#positiv").data({'positiv': 1, 'negativ': 0});
                    if($.cookie("cc"+{{$film->id}})!={{$film->id}}){
                        $('#rating').on('click', '.botton', function () {

                            var positiv = $(this).data("positiv");
                            var negativ = $(this).data("negativ");
                            // $( "body" ).data( "bar", "foobar" );
                            // alert(negativ);
                            // console.log(positiv);
                            $.ajax({
                                type:'POST',
                                url:'/ratingAdd',
                                data: {id: {{$film->id}}, positiv: positiv, negativ: negativ},
                                success: function(html){
                                    $("#rating").html(html);
                                    $("#negativ").data({'negativ': 1, 'positiv': 0});
                                    $("#positiv").data({'positiv': 1, 'negativ': 0});
                                    $.cookie("cc"+{{$film->id}}, {{$film->id}}, { expires: 350});
                                }
                            });

                        });
                    }else{
                        $(".botton,.qwestion").hide()
                    }
                }
            });


    </script>
@endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script>
        (function(d,s,id){var js,stags=d.getElementsByTagName(s)[0];
            if(d.getElementById(id)){return;}js=d.createElement(s);js.id=id;
            js.src='http://g-ec2.images-amazon.com/images/G/01/imdb/plugins/rating/js/rating.min.js';
            stags.parentNode.insertBefore(js,stags);})(document,'script','imdb-rating-api');
    </script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
<footer class="navbar-fixed-bottom" style="background: #080808; ">
    <div class="navbar-inner container">
        <p>На сайте публикуются даты сугубо официальных релизов, собранных из зарубежных источников.</p>
        <ul >
            <li>
                <a rel="nofollow" href="https://vk.com/amfeon90" title="Вконтакте">Я в Контактике</a>
            </li>
            <li >
                <a rel="nofollow" href="http://www.youtube.com/channel/UCPK8GKDoB01K8e0NEOgO_sw" title="ТыТруба">Я в Ютубушке</a>
            </li>
            <li >
                <a rel="author" href="https://plus.google.com/u/0/115214208930230673302">Я в Гугл+</a>
            </li>
        </ul>
     </div>
</footer>
</body>
</html>
