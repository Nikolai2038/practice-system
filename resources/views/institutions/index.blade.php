@extends('shared.layout')

@section('title', 'Предприятия / Учебные заведения')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Предприятия / Учебные заведения')

@section('sub_menu')
    <a href="{{ route('administration') }}" class="button button_blue button_size_small">Назад</a>
    <a href="{{ route('administration_institutions_create') }}" class="button button_red button_size_small">Добавить новое предприятие / учебное заведение</a>
@endsection

@section('content')
    @if(count($institutions) == 0)
        <p>
            Нет институтов!
        </p>
    @else
        <div class="mobile-table">
            <table class="table_not_linked">
                <thead>
                    <th>ID</th>
                    <th>Полное и краткое название, адрес</th>
                    <th class="td_small">Тип</th>
                    <th colspan="2">Действия</th>
                </thead>
                <tbody>
                @foreach($institutions as $institution)
                    <tr>
                        <td><span class="td_content">{{ $institution->id }}</span></td>
                        <td class="td_left">
                            <span class="td_content"><span class="institution_full_name">{{ $institution->full_name }}</span><br/>@if($institution->short_name != null)<span class="institution_short_name">Сокращённо: {{ $institution->short_name ?? '' }}</span><br/>@endif<span class="institution_address">{{ $institution->address }}</span></span>
                        </td>
                        <td class="td_small td_without_a"><span class="td_content">{{ $institution->institution_type->name ?? '-' }}</span></td>
                        <td class="td_small td_linked"><a href="{{ route('administration_institutions_edit', $institution->id) }}" class="td_content">Изменить</a></td>
                        <td class="td_small td_linked"><a href="{{ route('administration_institutions_delete', $institution->id) }}" class="td_content">Удалить</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $institutions->links('shared.pagination') }}
    @endif
@endsection
