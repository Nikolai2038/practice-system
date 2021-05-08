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
                    <a href="{{ route('index') }}" class="button button_blue button_size_small">Главная</a>
                    @if($total_user != null)
                        <a href="{{ route('contacts') }}" class="button button_blue button_size_small">Контакты</a>
                        <a href="{{ route('practices') }}" class="button button_blue button_size_small">Практики</a>
                        <a href="{{ route('chats') }}" class="button button_blue button_size_small">Чаты</a>
                        <a href="{{ route('users') }}" class="button button_blue button_size_small">Пользователи</a><br/>
                        @if($total_user->isDirector())
                            <a href="{{ route('register') }}" class="button button_green button_size_small">Зарегистрировать</a>
                            @if($total_user->isAdministrator() == false)
                                <br/>
                            @endif
                        @endif
                        @if($total_user->isAdministrator())
                            <a href="{{ route('administration') }}" class="button button_red button_size_small">Администрирование</a><br/>
                        @endif
                    @endif
                    @if($total_user == null)
                        <a href="{{ route('authorization') }}" class="button button_blue button_size_small">Авторизация</a>
                        <a href="{{ route('registration') }}" class="button button_blue button_size_small">Регистрация</a>
                    @else
                        <a href="{{ route('profile') }}" class="button button_blue button_size_small">Мой профиль</a>
                        <a href="{{ route('settings') }}" class="button button_blue button_size_small">Настройки</a>
                        <a href="{{ route('logout') }}" class="button button_blue button_size_small">Выйти из аккаунта</a>
                    @endif
                </nav>
            </header>
            <div id="content">
                <div class="page @yield('page_sized_class')">
                    <h1>@yield('page_title')</h1>
                    <div>
                        @section('sub_menu')
                        @show
                    </div>
                    <div class="page_center_content">
                        @section('content')
                            Контент не найден!
                        @show
                    </div>
                </div>
            </div>
        </div>
        <footer>
            © АИС "Прохождение производственной практики", 2021 г.
        </footer>
    </body>
</html>
