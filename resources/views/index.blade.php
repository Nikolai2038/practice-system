@extends('layout')
@section('title', 'Регистрация')
@section('content')
    <div class="page small_page">
        @if($total_user != null)
            <p>
                Добро пожаловать, {{ $total_user->login }}!
            </p>
        @else
            <p>
                Добро пожаловать в АИС "Прохождение производственной практики".
                Для начала работы, Вам необходимо получить <b>ссылку на регистрацию</b> от администратора АИС.
                Для входа в аккаунт используйте страницу "Авторизация".
            </p>
        @endif
    </div>
@endsection
