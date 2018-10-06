@extends('layouts\basic')

@section('content')
    <div class="modal-shadow"></div>

        <form id="contactform" method="POST" class="validateform">
            {{ csrf_field() }}

            <div id="sendmessage">
                Ваше сообщение отправлено!
            </div>
            <div id="senderror">
                При отправке сообщения произошла ошибка. Продублируйте его, пожалуйста, на почту администратора <span>{{-- env('MAIL_ADMIN_EMAIL') --}}</span>
            </div>
            <div class="body-form">
                <label style="padding: 20px; font-weight: 700;">Если вы не нашли фильм, который искали заполните поля и мы добавим его на сайт.</label>
                <div class="inner-form">
                    <input type="text" name="name" size="100" placeholder="* Введите Название фильма" required />
                </div>
                <div class="inner-form">
                    <input type="text" name="imdbLink" size="100" placeholder="* Введите ссылку на imdb" required />
                </div>
                <div class="inner-form">
                    <input type="text" name="kinopoiskLink" size="100" placeholder="* Введите ссылку на Кинопоиск" required />
                </div>
                <div class="footer-form">
                        <button class="btn btn-theme margintop10 pull-left" type="submit">Отправить</button>
                        <span class="pull-right margintop20">* Заполните, пожалуйста, все обязательные поля!</span>
                </div>
            </div>
        </form>

@endsection