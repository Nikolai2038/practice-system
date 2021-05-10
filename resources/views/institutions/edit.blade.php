@extends('shared.layout')

@section('title', 'Изменение предприятия / учебного заведения')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Изменение предприятия / учебного заведения')

@section('sub_menu')
    <a href="{{ route('administration_institutions') }}" class="button button_blue button_size_small">Назад</a>
@endsection

@section('content')
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        {!! $html_fields !!}
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
        <button class="button button_red button_size_normal">Изменить</button>
    </form>
@endsection
