@extends('layouts.basic')

@section('content')
<div class="container">

                    <form class="auth_form" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                         <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Введите Логин">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Введите пароль">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="auth_form_botton">
                            <input type="submit" name="submit" class="auth_botton" value=" Login"> </input>
                        </div>


                         <label>   <input type="checkbox" name="remember"> Remember Me       </label>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                    </form>
                </div>
@endsection
