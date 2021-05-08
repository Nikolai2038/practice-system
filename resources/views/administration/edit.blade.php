@extends('layouts.layout')

@section('title', $watching_user->getFullName().' - изменение роли пользователя')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', $watching_user->getFullName().' - изменение роли пользователя')

@section('sub_menu')
    <a href="{{ route('profile', $watching_user->id) }}" class="button button_blue button_size_small">Вернутся в профиль пользователя</a>
@endsection

@section('content')
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <div class="field_not_input">
            <label for="login">Роль: </label>
            <select name="role">
                @foreach($roles as $role)
                    <option
                        @if($watching_user->role == $role)
                            selected
                        @endif
                        @if($total_user->canChangeRoleTo($role) == false)
                            disabled
                        @endif
                    value={{ $role->id }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        @if($notification != null)
            <div class="notification">
                {{ $notification }}
            </div>
        @endif
        @if($errors != null)
            <div class="errors">
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <button class="button button_red button_size_normal">Изменить роль</button>
    </form>
@endsection
