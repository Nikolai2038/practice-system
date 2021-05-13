@extends('shared.layouts.page')

@section('title', 'Контакты')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Контакты')

@section('sub_menu')
    <a href="{{ route('contacts_requests_incoming') }}" class="button button_blue button_size_small">Входящие заявки ({{ $total_user->getIncomingContactsCount() }})</a>
    <a href="{{ route('contacts_requests_outcoming') }}" class="button button_blue button_size_small">Исходящие заявки ({{ $total_user->getOutcomingContactsCount() }})</a>
@endsection

@section('content')
    @if(count($users) == 0)
        <p>
            Нет контактов!
        </p>
    @else
        @include('shared.users_table_with_avatars')
    @endif
@endsection
