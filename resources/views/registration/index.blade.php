@extends('layouts.layout')
@section('title', 'Регистрация')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection
@section('page_sized_class', 'small_page')
@section('page_title', 'Регистрация')
@section('content')
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <div class="field">
            <input type="text" placeholder=" " name="login" id="login" value="{{ $form_data['login'] ?? '' }}" required/>
            <label for="login">Логин *</label>
        </div>
        <div class="field">
            <input type="text" placeholder=" " name="email" id="email" value="{{ $form_data['email'] ?? '' }}"/>
            <label for="email">Email</label>
        </div>
        <div class="field">
            <input type="text" placeholder=" " name="first_name" id="first_name" value="{{ $form_data['first_name'] ?? '' }}" required/>
            <label for="first_name">Имя *</label>
        </div>
        <div class="field">
            <input type="text" placeholder=" " name="second_name" id="second_name" value="{{ $form_data['second_name'] ?? '' }}" required/>
            <label for="second_name">Фамилия *</label>
        </div>
        <div class="field">
            <input type="text" placeholder=" " name="third_name" id="third_name" value="{{ $form_data['third_name'] ?? '' }}" />
            <label for="third_name">Отчество</label>
        </div>
        <div class="field">
            <input type="password" placeholder=" " name="password" id="password" value="{{ $form_data['password'] ?? '' }}" required/>
            <label for="password">Пароль *</label>
        </div>
        <div class="field">
            <input type="password" placeholder=" " name="password_confirmed" id="password_confirmed" value="{{ $form_data['password_confirmed'] ?? '' }}" required/>
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
