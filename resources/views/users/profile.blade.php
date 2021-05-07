@extends('layout')
@if($watching_user == null)
    @section('title', 'Пользователь не найден!')
@else
    @section('title', $watching_user->getFullName())
@endif
@section('content')
    <div class="page big_page">
        @if($watching_user == null)
                Пользователь не найден!
        @else
            <p>
                профиль {{ $watching_user->getFullName() }}
            </p>
        @endif
    </div>
@endsection
