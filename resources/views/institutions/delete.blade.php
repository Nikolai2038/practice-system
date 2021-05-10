@extends('shared.layout')

@section('title', 'Удаление предприятия / учебного заведения')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Удаление предприятия / учебного заведения')

@section('sub_menu')
    <a href="{{ route('administration_institutions') }}" class="button button_blue button_size_small">Назад</a>
@endsection

@section('content')
    <div class="mobile-table">
        <table class="table_not_linked">
            <thead>
            <th>ID</th>
            <th>Полное и краткое название, адрес</th>
            <th class="td_small">Тип</th>
            </thead>
            <tbody>
                <tr>
                    <td><span class="td_content">{{ $institution->id }}</span></td>
                    <td class="td_left">
                        <span class="td_content"><span class="institution_full_name">{{ $institution->full_name }}</span><br/>@if($institution->short_name != null)<span class="institution_short_name">Сокращённо: {{ $institution->short_name ?? '' }}</span><br/>@endif<span class="institution_address">{{ $institution->address }}</span></span>
                    </td>
                    <td class="td_small td_without_a"><span class="td_content">{{ $institution->institution_type->name ?? '-' }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <div class="errors">
            <p>
                Вы действительно хотите удалить это предприятие / учебное заведение?
            </p>
        </div>
        <button class="button button_red button_size_normal">Удалить</button>
    </form>
@endsection
