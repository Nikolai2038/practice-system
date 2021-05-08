@extends('shared.layout')

@section('title', $watching_user->getFullName())

@section('page_sized_class', 'big_page')

@section('page_title', $watching_user->getFullName())

@section('sub_menu')
    @if($total_user->isAdministrator())
        @if(($total_user->canChangeRoleOfUser($watching_user)))
            <a href="{{ route('administration_roles_edit', $watching_user->id) }}" class="button button_red button_size_small">Изменить роль</a>
        @endif
    @endif
@endsection

@section('content')
    <p>
        профиль {{ $watching_user->getFullName() }}
    </p>
    <p>
        профиль {{ $watching_user->getFullName() }}
    </p>
@endsection
