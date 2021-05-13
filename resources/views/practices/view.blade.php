@extends('shared.layouts.page')

@section('title', 'Чат практики '.$practice->name)

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/chat.css') }}" type="text/css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ URL::asset('js/chat.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Чат практики '.$practice->name)

@section('sub_menu')
    <a href="{{ route('practices') }}" class="button button_blue button_size_small">Вернуться назад к списку практик</a>
    @if($total_user->hasPermissionOnPractice($practice))
        <a href="{{ route('practices_edit', $practice->id) }}" class="button button_green button_size_small">Изменить практику</a>
        <a href="{{ route('practices_delete', $practice->id) }}" class="button button_green button_size_small">Удалить практику</a>
    @endif
@endsection

@section('content')
    <script>
        chat_id = {{ $chat->id }};
    </script>
    <script src="{{ URL::asset('js/IN_DOCUMENT_chat_textarea_submit.js') }}"></script>
    @include('shared.chat')

    <h3>
        Участники практики
    </h3>
    @if(count($users) == 0)
        <p>
            Нет участников практики!
        </p>
    @else
        @include('shared.users_table_with_avatars')
    @endif
@endsection
