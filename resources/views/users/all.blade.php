@extends('shared.layout')

@section('title', 'Пользователи')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Пользователи')

@section('content')
    <div class="mobile-table">
        <table class="table_main">
            <thead>
            <th>ID</th>
            <th>ФИО</th>
            <th class="td_small">Email</th>
            <th class="td_small">Телефон</th>
            <th class="td_small">Дата регистрации</th>
            <th class="td_small">Последний раз онлайн</th>
            <th class="td_small">Роль</th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->id }}</a></td>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->getFullName() }}</a></td>
                    <td class="td_small"><a href="{{ route('profile', $user->id) }}">{{ $user->email ?? '-' }}</a></td>
                    <td class="td_small"><a href="{{ route('profile', $user->id) }}">{{ $user->phone ?? '-' }}</a></td>
                    <td class="td_small"><a href="{{ route('profile', $user->id) }}">{{ $user->created_at }}</a></td>
                    <td class="td_small"><a href="{{ route('profile', $user->id) }}">{{ $user->last_activity_at }}<br/>({{ $user->echoActivityStatus() }})</a></td>
                    <td class="td_small"><a href="{{ route('profile', $user->id) }}">{{ $user->role->name }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links('shared.pagination') }}
@endsection
