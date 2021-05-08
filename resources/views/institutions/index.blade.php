@extends('shared.layout')

@section('title', 'Предприятия / Учебные заведения')

@section('page_sized_class', 'big_page')

@section('page_title', 'Предприятия / Учебные заведения')

@section('sub_menu')
    <a href="{{ route('administration') }}" class="button button_blue button_size_small">Назад</a>
    <a href="{{ route('administration_institutions_create') }}" class="button button_red button_size_small">Добавить новое предприятие / учебное заведение</a>
@endsection

@section('content')
    <div class="mobile-table">
        <table class="table_main">
            <thead>
            <th>ID</th>
            <th>Полное и краткое название, адрес</th>
            <th class="td_small">Тип</th>
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
