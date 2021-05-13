<html>
    <head>
        <title>@yield('title')</title>
        @section('css')
            <link rel="stylesheet" href="{{ URL::asset('css/all.css') }}" type="text/css">
            <link rel="preconnect" href="https://fonts.gstatic.com"> {{-- Для шрифтов --}}
            <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&family=Roboto&display=swap" rel="stylesheet"> {{-- Для шрифтов --}}
        @show
        @section('scripts')
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
                    @if($total_user == null)
                        <a href="{{ route('authorization') }}" class="button button_blue button_size_small">Авторизация</a>
                        <a href="{{ route('registration') }}" class="button button_blue button_size_small">Регистрация</a>
                    @else
                        <a href="{{ route('users') }}" class="button button_blue button_size_small">Пользователи</a>
                        @if($total_user->isAdministrator())
                            <a href="{{ route('administration') }}" class="button button_red button_size_small">Администрирование</a>
                        @endif
                        <br/>
                        <a href="{{ route('my_profile') }}" class="button button_blue button_size_small">Профиль</a>
                        <a href="{{ route('contacts') }}" class="button button_blue button_size_small">Контакты@if($total_user->getIncomingContactsCount() > 0) (+{{ $total_user->getIncomingContactsCount() }})@endif</a>
                        <a href="{{ route('chats') }}" class="button button_blue button_size_small">Личные чаты@if($total_user->getCountNewMessagesInPersonalChats() > 0) (+{{ $total_user->getCountNewMessagesInPersonalChats() }})@endif</a>
                        <a href="{{ route('practices') }}" class="button button_blue button_size_small">Практики@if($total_user->getCountNewMessagesInPracticChats() > 0) (+{{ $total_user->getCountNewMessagesInPracticChats() }})@endif</a>
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
                        @show
                    </div>
                </div>
            </div>
        </div>
        @section('scripts')
        @show
        <footer>
            © АИС "Прохождение производственной практики", 2021 г.
        </footer>
    </body>
</html>
