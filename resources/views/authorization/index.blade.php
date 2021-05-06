@extends('layout')
@section('title', 'Авторизация')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection
@section('content')
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <h1>Авторизация</h1>
        <div class="field">
            <input type="text" placeholder=" " name="login" id="login" value="{{ $form_data['login'] ?? '' }}" required/>
            <label for="login">Логин *</label>
        </div>
        <div class="field">
            <input type="password" placeholder=" " name="password" id="password" value="{{ $form_data['password'] ?? '' }}" required/>
            <label for="password">Пароль *</label>
        </div>
        <div class="errors">
            @if($errors != null)
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @endif
        </div>
        <button>Авторизоваться</button><br/>
        <br/>
        <a href="{{ route('registration') }}">Регистрация</a>
    </form>
@endsection
