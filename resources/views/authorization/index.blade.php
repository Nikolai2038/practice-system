@extends('shared.layout')

@section('title', 'Авторизация')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'small_page')

@section('page_title', 'Авторизация')

@section('content')
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <div class="field">
            <input type="text" placeholder=" " name="login" id="login" value="{{ $form_data['login'] ?? '' }}" required/>
            <label for="login">Логин *</label>
        </div>
        <div class="field">
            <input type="password" placeholder=" " name="password" id="password" value="{{ $form_data['password'] ?? '' }}" required/>
            <label for="password">Пароль *</label>
        </div>
        @if($errors != null)
            <div class="errors">
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <button class="button button_blue button_size_normal">Авторизоваться</button><br/>
        <br/>
        <a href="{{ route('registration') }}">Регистрация</a>
    </form>
@endsection
