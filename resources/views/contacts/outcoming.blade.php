@extends('shared.layouts.page')

@section('title', 'Контакты - Исходящие заявки')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Контакты - Исходящие заявки')

@section('sub_menu')
    <a href="{{ route('contacts') }}" class="button button_blue button_size_small">Вернуться к списку контактов</a>
@endsection

@section('content')
    @if(count($users) == 0)
        <p>
            Нет исходящих заявок!
        </p>
    @else
        @include('shared.users_table_with_avatars')
    @endif
@endsection
