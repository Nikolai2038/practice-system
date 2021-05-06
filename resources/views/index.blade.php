@extends('layout')
@section('title', 'Регистрация')
@section('content')
    Добро пожаловать, {{ $total_user->login ?? 'Аноним' }}!<br/>
    @if($total_user != null)
        <a href="{{ route('logout') }}">Выйти</a>
    @else
        <a href="{{ route('authorization') }}">Авторизация</a><br/>
        <a href="{{ route('registration') }}">Регистрация</a>
    @endif
@endsection
