@extends('shared.layouts.page')

@section('title', 'Личные чаты')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Личные чаты')

@section('content')
    @if(count($chats) == 0)
        <p>
            У вас нет активных личных чатов!
        </p>
        <p>
            Создать личный чат можно на странице "Мои контакты", а также в самом профиле целевого пользователя.
        </p>
    @else
        <div class="mobile-table">
            <table class="table_not_linked">
                <thead>
                <th>Чат с пользователем</th>
                <th class="td_small">Последний раз онлайн</th>
                <th class="td_small">Действия</th>
                </thead>
                <tbody>
                @foreach($chats as $chat)
                    <tr>
                        <td class="td_linked td_none_padding td_left">
                            <a href="{{ route('chats_view', $chat->id) }}" class="td_content"><div class="td_a_div"><img src="{{ $chats_users[$loop->index]->getAvatarFileSrc() }}" alt="Изображение не найдено" class="contact_avatar" /><div class="contact_name">{{ $chats_users[$loop->index]->getFullName() }}</div><br/>@if(($chats_users[$loop->index]->email != null) && ($chats_users[$loop->index]->email != 'Скрыт')){{ $chats_users[$loop->index]->email ?? '' }}@if(($chats_users[$loop->index]->phone != null) && ($chats_users[$loop->index]->phone != 'Скрыт')){{ ', ' }}@endif{{ '' }}@endif{{ '' }}@if(($chats_users[$loop->index]->phone != null) && ($chats_users[$loop->index]->phone != 'Скрыт')){{ $chats_users[$loop->index]->phone ?? '' }}@endif</div></a>
                        </td>
                        <td class="td_small">{{ $chats_users[$loop->index]->last_activity_at }}<br/>({{ $chats_users[$loop->index]->echoActivityStatus() }})</td>
                        <td class="td_small td_linked td_small_padding">
                            <a href="{{ route('chats_delete', $chats_users[$loop->index]->id) }}" class="td_content">Удалить личный чат с пользователем</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
