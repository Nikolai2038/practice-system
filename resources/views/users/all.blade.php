@extends('shared.layouts.page')

@section('title', 'Пользователи')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Пользователи')

@section('content')
    @if(count($users) == 0)
        <p>
            Нет пользователей!
        </p>
    @else
        <div class="mobile-table">
            <table class="table_linked">
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
                        <td><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->id }}</a></td>
                        <td><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->getFullName() }}</a></td>
                        <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->email ?? '-' }}</a></td>
                        <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->phone ?? '-' }}</a></td>
                        <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->created_at }}</a></td>
                        <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->last_activity_at }}<br/>({{ $user->echoActivityStatus() }})</a></td>
                        <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->role->name }}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links('shared.pagination') }}
    @endif
@endsection
