@extends('shared.layout')

@section('title', 'Выдача бана пользователю '.$watching_user->getFullName())

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Выдача бана пользователю '.$watching_user->getFullName())

@section('sub_menu')
    <a href="{{ route('bans_view', $watching_user->id) }}" class="button button_blue button_size_small">Вернуться к списку блокировок пользователя</a>
@endsection

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
        <button class="button button_blue button_size_normal">Выдать бан</button>
    </form>
@endsection
