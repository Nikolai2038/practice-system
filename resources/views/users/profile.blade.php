@extends('shared.layout')

@section('title', $watching_user->getFullName())

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', $watching_user->getFullName())

@section('sub_menu')
    @if($total_user->id == $watching_user->id)
        <a href="{{ route('settings') }}" class="button button_blue button_size_small">Настройки</a>
    @endif
    <a href="{{ route('bans_view', $watching_user->id) }}" class="button button_blue button_size_small">Посмотреть баны, полученные пользователем</a>
    @if($total_user->isAdministrator())
        <br/>
        @if(($total_user->canChangeRoleOfUser($watching_user)))
            <a href="{{ route('administration_roles_edit', $watching_user->id) }}" class="button button_red button_size_small">Изменить роль</a>
        @endif
        @if(($total_user->canBanUser($watching_user)))
            <a href="{{ route('administration_bans_create', $watching_user->id) }}" class="button button_red button_size_small">Забанить</a>
        @endif
    @endif
@endsection

@section('content')
    <div class="mobile-table">
        <table class="table_not_linked profile_table">
            <tr>
                <td><b>{{ $watching_user->role->name }}</b><br/>{{ $watching_user->echoActivityStatus() }}</td>
                <th colspan="2">Информация</th>
            </tr>
            <tr>
                <td rowspan="10" class="profile_avatar">
                    <img src="{{ $watching_user->getAvatarFileSrc() }}" alt="Не найдена" class="profile_avatar" /><br/>
                </td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">ID:</td>
                <td class="profile_field">{{ $watching_user->id }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Имя:</td>
                <td>{{ $watching_user->first_name }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Фамилия:</td>
                <td>{{ $watching_user->second_name }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Отчество:</td>
                <td>{{ $watching_user->third_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Email:</td>
                <td>{{ $watching_user->email ?? '-' }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Телефон:</td>
                <td>{{ $watching_user->phone ?? '-' }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Дата регистрации:</td>
                <td>{{ $watching_user->created_at }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Дата последнего онлайна:</td>
                <td>{{ $watching_user->last_activity_at }}</td>
            </tr>
            <tr>
                <td class="profile_field profile_field_header">Предприятие / Учебное заведение:</td>
                <td>@if($watching_user->institution != null)<span class="td_content"><span class="institution_full_name">{{ $watching_user->institution->full_name }}</span><br/>@if($watching_user->institution->short_name != null)<span class="institution_short_name">Сокращённо: {{ $watching_user->institution->short_name ?? '' }}</span><br/>@endif<span class="institution_address">{{ $watching_user->institution->address }}</span></span>@else - @endif</td>
            </tr>
        </table>
    </div>
@endsection
