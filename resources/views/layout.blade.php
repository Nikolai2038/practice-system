<html>
    <head>
        <title>@yield('title')</title>
        @section('css')
            <link rel="stylesheet" href="{{ URL::asset('css/all.css') }}" type="text/css">
        @show
    </head>
    <body>
        <header>
            Шапка
        </header>
        @section('content')
            Добро пожаловать!
        @show
        <footer>
            Подвал
        </footer>
    </body>
</html>
