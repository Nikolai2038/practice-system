@extends('shared.layouts.page')

@section('title', 'Снятие бана пользователя '.$ban->user_to->getFullName())

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Снятие бана пользователя '.$ban->user_to->getFullName())

@section('sub_menu')
    <a href="{{ route('bans_view', $ban->user_to->id) }}" class="button button_blue button_size_small">Назад</a>
@endsection

@section('content')
    <div class="mobile-table">
        <table class="table_not_linked">
            <thead>
                <th>ID</th>
                <th>Пользователю</th>
                <th>От администратора</th>
                <th>Причина</th>
                <th class="td_small">Дата выдачи</th>
                <th class="td_small">Дата разбана</th>
            </thead>
            <tbody>
                <tr>
                    <td><span class="td_content">{{ $ban->id }}</span></td>
                    <td class="td_linked"><a href="{{ route('profile', $ban->user_to->id) }}" class="td_content">{{ $ban->user_to->getFullName() }}</a></td>
                    <td class="td_linked"><a href="{{ route('profile', $ban->user_from->id) }}" class="td_content">{{ $ban->user_from->getFullName() }}</a></td>
                    <td><span class="td_content">{{ $ban->description ?? '-' }}</span></td>
                    <td class="td_small"><span class="td_content">{{ $ban->created_at }}</span></td>
                    <td class="td_small"><span class="td_content">@if($ban->is_permanent)Никогда@else{{ $ban->unban_at }}@endif @if($ban->isActive())<span class="ban_active">(Действует)</span>@else<span class="ban_gone">(Истёк)</span>@endif</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <div class="errors">
            <p>
                Вы действительно хотите снять этот бан?<br/>
                (Это устанавливает дату и время разбана на текущую, сам бан остаётся в истории)
            </p>
        </div>
        <button class="button button_red button_size_normal">Снять</button>
    </form>
@endsection
