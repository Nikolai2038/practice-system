@extends('shared.layouts.page')

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
            Добро пожаловать в АИС "Прохождение производственной практики".<br/>
            Для входа в аккаунт используйте страницу "Авторизация".
        </p>
    @endif
@endsection
