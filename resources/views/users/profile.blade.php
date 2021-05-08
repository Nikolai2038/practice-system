@extends('layouts.layout')

@if($watching_user == null)
    @section('title', 'Пользователь не найден!')
@else
    @section('title', $watching_user->getFullName())
@endif

@section('page_sized_class', 'big_page')

@if($watching_user == null)
    @section('page_title', 'Пользователь не найден!')
@else
    @section('page_title', $watching_user->getFullName())
@endif

@section('sub_menu')
    @if($watching_user != null)
        @if($total_user->isAdministrator())
            @if(($total_user->canChangeRoleOfUser($watching_user)))
                <a href="{{ route('administration_roles_edit', $watching_user->id) }}" class="button button_red button_size_small">Изменить роль</a>
            @endif
        @endif
    @endif
@endsection

@section('content')
    @if($watching_user == null)
            Пользователь не найден!
    @else
        <p>
            профиль {{ $watching_user->getFullName() }}
        </p>
        <p>
            профиль {{ $watching_user->getFullName() }}
        </p>
    @endif
@endsection
