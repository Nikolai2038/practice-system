@extends('layout')
@section('title', 'Регистрация')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection
@section('content')
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <h1>Регистрация</h1>
        <div class="field">
            <input type="text" placeholder=" " name="login" id="login" required/>
            <label for="login">Логин *</label>
        </div>
        <div class="field">
            <input type="password" placeholder=" " name="email" id="email"/>
            <label for="email">Email</label>
        </div>
        <div class="field">
            <input type="text" placeholder=" " name="first_name" id="first_name" required/>
            <label for="first_name">Имя *</label>
        </div>
        <div class="field">
            <input type="text" placeholder=" " name="second_name" id="second_name" required/>
            <label for="second_name">Фамилия *</label>
        </div>
        <div class="field">
            <input type="text" placeholder=" " name="third_name" id="third_name"/>
            <label for="third_name">Отчество</label>
        </div>
        <div class="field">
            <input type="password" placeholder=" " name="password" id="password" required/>
            <label for="password">Пароль *</label>
        </div>
        <div class="field">
            <input type="password" placeholder=" " name="password_confirmed" id="password_confirmed" required/>
            <label for="password_confirmed">Подтверждение пароля *</label>
        </div>
        <div class="errors">
            @if($errors != null)
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @endif
        </div>
        <button>Зарегистрироваться</button><br/>
        <br/>
        <a href="{{ route('authorization') }}">Авторизация</a>
    </form>
@endsection
