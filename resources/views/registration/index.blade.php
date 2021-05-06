@extends('layout')
@section('title', 'Регистрация')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection
@section('content')
    <form method="POST" action="/registration/checkForm" class="form_main">
        <h1>Регистрация</h1>
        <div>
            <input type="text" placeholder=" " name="login" id="login" required autofocus/>
            <label for="login">Логин *</label>
        </div>
        <div>
            <input type="password" placeholder=" " name="email" id="email"/>
            <label for="email">Email</label>
        </div>
        <div>
            <input type="password" placeholder=" " name="password" id="password" required/>
            <label for="password">Пароль *</label>
        </div>
        <div>
            <input type="password" placeholder=" " name="password_confirmed" id="password_confirmed" required/>
            <label for="password_confirmed">Подтверждение пароля *</label>
        </div>
        <button>Зарегистрироваться</button><br/>
        <br/>
        <a href="{{ route('authorization') }}">Авторизация</a>
    </form>
@endsection
