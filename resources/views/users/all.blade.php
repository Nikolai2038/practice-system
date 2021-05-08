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
        <table class="table_users">
            <thead>
            <th>ID</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Отчество</th>
            <th>Email</th>
            <th>Дата регистрации</th>
            <th>Последний раз онлайн</th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->id }}</a></td>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->first_name }}</a></td>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->second_name }}</a></td>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->third_name ?? '-' }}</a></td>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->email ?? '-' }}</a></td>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->created_at }}</a></td>
                    <td><a href="{{ route('profile', $user->id) }}">{{ $user->last_activity_at }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links('shared.pagination') }}
@endsection
