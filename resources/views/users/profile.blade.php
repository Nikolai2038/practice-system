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

@section('content')
    @if($watching_user == null)
            Пользователь не найден!
    @else
        <p>
            профиль {{ $watching_user->getFullName() }}
        </p>
    @endif
@endsection
