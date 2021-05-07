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
                    <a href="{{ route('index') }}" class="button button_blue">Главная</a>
                    @if($total_user != null)
                        <a href="{{ route('contacts') }}" class="button button_blue">Контакты</a>
                        <a href="{{ route('practices') }}" class="button button_blue">Практики</a>
                        <a href="{{ route('chats') }}" class="button button_blue">Чаты</a>
                        <a href="{{ route('users') }}" class="button button_blue">Пользователи</a><br/>
                        @if($total_user->isDirector())
                            <a href="{{ route('register') }}" class="button button_green">Зарегистрировать</a>
                            @if($total_user->isAdministrator() == false)
                                <br/>
                            @endif
                        @endif
                        @if($total_user->isAdministrator())
                            <a href="{{ route('administration') }}" class="button button_red">Администрирование</a><br/>
                        @endif
                    @endif
                    @if($total_user == null)
                        <a href="{{ route('authorization') }}" class="button button_blue">Авторизация</a>
                        <a href="{{ route('registration') }}" class="button button_blue">Регистрация</a>
                    @else
                        <a href="{{ route('profile') }}" class="button button_blue">Мой профиль</a>
                        <a href="{{ route('settings') }}" class="button button_blue">Настройки</a>
                        <a href="{{ route('logout') }}" class="button button_blue">Выйти из аккаунта</a>
                    @endif
                </nav>
            </header>
            <div id="content">
                <div class="page @yield('page_sized_class')">
                    <h1>@yield('page_title')</h1>
                    @section('content')
                        Контент не найден!
                    @show
                </div>
            </div>
        </div>
        <footer>
            © АИС "Прохождение производственной практики", 2021 г.
        </footer>
    </body>
</html>
