@extends('shared.layout')

@section('title', 'Предприятия / Учебные заведения')

@section('page_sized_class', 'big_page')

@section('page_title', 'Предприятия / Учебные заведения')

@section('sub_menu')
    <a href="{{ route('administration') }}" class="button button_blue button_size_small">Назад</a>
    <a href="{{ route('administration_institutions_create') }}" class="button button_red button_size_small">Добавить новое предприятие / учебное заведение</a>
@endsection

@section('content')
    <p>
        123
    </p>
@endsection
