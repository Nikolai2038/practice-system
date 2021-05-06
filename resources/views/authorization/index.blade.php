@extends('layout')
@section('title', 'Авторизация')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection
@section('content')
    <form method="POST" action="/registration/checkForm" class="form_main">
        <h1>Авторизация</h1>
        <div>
            <input type="text" placeholder=" " name="login" id="login" required autofocus/>
            <label for="login">Логин *</label>
        </div>
        <div>
            <input type="password" placeholder=" " name="password" id="password" required/>
            <label for="password">Пароль *</label>
        </div>
        <button>Авторизоваться</button><br/>
        <br/>
        <a href="{{ route('registration') }}">Регистрация</a>
    </form>
@endsection
