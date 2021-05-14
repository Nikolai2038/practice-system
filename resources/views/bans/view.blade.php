@extends('shared.layouts.page')

@section('title', 'Баны пользователя '.$watching_user->getFullName())

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Баны пользователя '.$watching_user->getFullName())

@section('sub_menu')
    <a href="{{ route('profile', $watching_user->id) }}" class="button button_blue button_size_small">Вернуться в профиль</a>
    @if(($total_user->canBanUser($watching_user)))
        <a href="{{ route('administration_bans_create', $watching_user->id) }}" class="button button_red button_size_small">Забанить</a>
    @endif
@endsection

@section('content')
    @if(count($bans) == 0)
        <p>
            Этот пользователь не получал блокировок!
        </p>
    @else
        <div class="mobile-table">
            <table class="table_not_linked">
                <thead>
                <th>ID</th>
                <th>Пользователю</th>
                <th>От администратора</th>
                <th>Причина</th>
                <th class="td_small">Дата выдачи</th>
                <th class="td_small">Дата разбана</th>
                <th colspan="2">Действия</th>
                </thead>
                <tbody>
                @foreach($bans as $ban)
                    <tr>
                        <td><span class="td_content">{{ $ban->id }}</span></td>
                        <td class="td_linked"><a href="{{ route('profile', $ban->user_to->id) }}" class="td_content">{{ $ban->user_to->getFullName() }}</a></td>
                        <td class="td_linked"><a href="{{ route('profile', $ban->user_from->id) }}" class="td_content">{{ $ban->user_from->getFullName() }}</a></td>
                        <td><span class="td_content">{{ $ban->description ?? '-' }}</span></td>
                        <td class="td_small"><span class="td_content">{{ $ban->created_at }}</span></td>
                        <td class="td_small"><span class="td_content">@if($ban->is_permanent)Никогда@else{{ $ban->unban_at }}@endif @if($ban->isActive())<span class="ban_active">(Действует)</span>@else<span class="ban_gone">(Истёк)</span>@endif</span></td>
                        @if($total_user->canUnbanBan($ban))
                            <td class="td_small td_linked"><a href="{{ route('administration_bans_unban', $ban->id) }}" class="td_content">Снять бан</a></td>
                        @else
                            <td class="td_small">-</td>
                        @endif
                        @if($total_user->canDeleteBan($ban))
                            <td class="td_small td_linked"><a href="{{ route('administration_bans_delete', $ban->id) }}" class="td_content">Удалить бан</a></td>
                        @else
                            <td>-</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $bans->links('shared.pagination') }}
    @endif
@endsection
