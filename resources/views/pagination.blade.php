@foreach($films as $film)
    <li>
        <div class='poster'>
            <div class="stripe_up">
                {{$film->title}}
            </div>
            <a href='film/{{$film->id}}'>
                <img  width="150" height="250" src ='{{$film->image}}' alt='Подробенее о фильме {{$film->title}}' title='Подробнее о фильме {{$film->title}}'/>
            </a>
            <div class="stripe_down">Дата Выхода:<br/> {{$film->date_release}}</div>
        </div>
    </li>
@endforeach
