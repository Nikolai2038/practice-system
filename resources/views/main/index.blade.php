@extends('shared.layout')

@section('title', 'Главная')

@section('page_sized_class', 'small_page')

@section('page_title', 'Главная')

@section('content')
    @if($total_user != null)
        <p>
            Добро пожаловать, {{ $total_user->getFullName() }}!
        </p>
    @else
        <p>
            Добро пожаловать в АИС "Прохождение производственной практики".
            Для начала работы, Вам необходимо получить <b>ссылку на регистрацию</b> от администратора АИС.
            Для входа же в аккаунт используйте страницу "Авторизация".
        </p>
    @endif
@endsection
