<html>
    <head>
        <title>@yield('title')</title>
        @section('css')
            <link rel="stylesheet" href="{{ URL::asset('css/all.css') }}" type="text/css">
            <link rel="preconnect" href="https://fonts.gstatic.com"> {{-- Для шрифтов --}}
            <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&family=Roboto&display=swap" rel="stylesheet"> {{-- Для шрифтов --}}
        @show
    </head>
    <body>
        <div id="not_footer">
            <header>
                <div id="logo">
                    <a href="{{ route('index') }}">АИС "ППП"</a>
                </div>
                <nav id="menu">
                    <a href="{{ route('index') }}">Главная</a>
                    @if($total_user == null)
                        <a href="{{ route('authorization') }}">Авторизация</a>
                        <a href="{{ route('registration') }}">Регистрация</a>
                    @else
                        <a href="{{ route('profile') }}">Мой профиль</a>
                        <a href="{{ route('users') }}">Пользователи</a>
                        <a href="{{ route('logout') }}">Выйти из аккаунта</a>
                    @endif
                </nav>
            </header>
            <div id="content">
                @section('content')
                    Контент не найден!
                @show
            </div>
        </div>
        <footer>
            © АИС "Прохождение производственной практики", 2021 г.
        </footer>
    </body>
</html>
