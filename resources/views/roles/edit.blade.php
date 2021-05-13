@extends('shared.layouts.page')

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
        @if($notification != null)
            <div class="notification">
                {{ $notification }}
            </div>
        @endif
        {!! $html_fields !!}
        @if($errors != null)
            <div class="errors">
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <button class="button button_green button_size_normal">Изменить</button>
    </form>
@endsection
