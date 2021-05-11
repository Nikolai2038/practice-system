@extends('shared.layout')

@section('title', 'Личный чат')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Личный чат')

@section('sub_menu')
    @if($chat->chat_type->id == App\Models\ChatType::CHAT_TYPE_ID_PERSONAL)
        <a href="{{ route('chats') }}" class="button button_blue button_size_small">Вернуться к списку личных чатов</a>
        <a href="{{ route('chats_delete', $chat->id) }}" class="button button_blue button_size_small">Удалить личный чат с пользователем</a>
    @else
    @endif
@endsection

@section('content')

    <div id="chat"></div>
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="name" class="col-sm-3 col-sm-offset-1 control-label">Ваше имя для чата</label>
            <div class="col-sm-4 ">
                <input type="text" class="form-control"  id="name" placeholder="Введите ваше имя" name="name"/>
            </div>
        </div>
    </form>
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="text" class="col-sm-3 col-sm-offset-1 control-label">Ваше сообщение</label>
            <div class="col-sm-7 ">
                <textarea class="form-control" rows="3" id="text" placeholder="Введите ваш сообщение" name="text"></textarea>
            </div>
        </div>
    </form>
    <div class="col-sm-offset-4 col-sm-4 col-xs-offset-2  col-xs-7">
        <button  id="btnSend" class="submit btn btn-primary col-sm-12 col-xs-12 btn-lg">Отправить сообщение</button>
    </div>
@endsection
