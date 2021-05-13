@extends('shared.layouts.page')

@section('title', $chat->name ?? 'Личный чат с пользователем '.$chat->getSecondUserIfChatIsPersonal($total_user)->getFullName())

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

@section('page_title', $chat->name ?? 'Личный чат с пользователем '.$chat->getSecondUserIfChatIsPersonal($total_user)->getFullName())

@section('sub_menu')
    @if($chat->chat_type->id == App\Models\ChatType::CHAT_TYPE_ID_PERSONAL)
        <a href="{{ route('chats') }}" class="button button_blue button_size_small">Вернуться к списку личных чатов</a>
        <a href="{{ route('chats_delete', $chat->getSecondUserIfChatIsPersonal($total_user)->id) }}" class="button button_blue button_size_small">Удалить личный чат с пользователем</a>
    @else
    @endif
@endsection

@section('content')
    <script>
        chat_id = {{ $chat->id }};
    </script>
    <script src="{{ URL::asset('js/IN_DOCUMENT_chat_textarea_submit.js') }}"></script>
    @include('shared.chat')
@endsection
