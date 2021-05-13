@extends('shared.layouts.page')

@section('title', 'Регистрация')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'small_page')

@section('page_title', 'Регистрация')

@section('content')
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        {!! $html_fields !!}
        @if($errors != null)
            <div class="errors">
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <button class="button button_blue button_size_normal">Зарегистрироваться</button><br/>
        <br/>
        <a href="{{ route('authorization') }}">Авторизация</a>
    </form>
@endsection
