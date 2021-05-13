@extends('shared.layouts.page')

@section('title', 'Специальные роли пользователей')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Специальные роли пользователей')

@section('sub_menu')
    <a href="{{ route('administration') }}" class="button button_blue button_size_small">Назад</a>
@endsection

@section('content')
    @foreach($roles as $role)
        <h3>
            Пользователи с ролью {{ $role->name }}
        </h3>
        @if(count($role->users) == 0)
            <p>
                Нет пользователей с этой ролью!
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
                    </thead>
                    <tbody>
                    @foreach($role->users as $user)
                        <tr>
                            <td><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->id }}</a></td>
                            <td><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->getFullName() }}</a></td>
                            <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->email ?? '-' }}</a></td>
                            <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->phone ?? '-' }}</a></td>
                            <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->created_at }}</a></td>
                            <td class="td_small"><a href="{{ route('profile', $user->id) }}" class="td_content">{{ $user->last_activity_at }}<br/>({{ $user->echoActivityStatus() }})</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach
@endsection
