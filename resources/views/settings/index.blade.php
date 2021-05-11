@extends('shared.layout')

@section('title', 'Настройки')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('scripts')
    <script src="js/checkFileSize.js"></script>
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Настройки')

@section('sub_menu')
    <a href="{{ route('my_profile') }}" class="button button_blue button_size_small">Вернуться в профиль</a>
@endsection

@section('content')
    <form method="POST" class="form_main" enctype="multipart/form-data" onsubmit="return checkFileSize(3)">
        {{ csrf_field() }}
        @if($notification != null)
            <div class="notification">
                {{ $notification }}
            </div>
        @endif
        <div class="field_not_input">
            <label>Текущая аватарка: </label><br/>
            <img src="{{ $total_user->getAvatarFileSrc() }}" alt="Изображение не найдено" class="settings_avatar" /><br/>
            <label>Новая аватарка: </label>
            <input name="avatar" type="file" id="upload" accept="image/png,image/jpeg,image/gif" />
        </div>
        {!! $html_fields !!}
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
