@extends('shared.layouts.page')

@section('title', 'Удаление практики '.$practice->name)

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}" type="text/css">
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', 'Удаление практики '.$practice->name)

@section('sub_menu')
    <a href="{{ route('practices_view', $practice->id) }}" class="button button_blue button_size_small">Назад</a>
@endsection

@section('content')
    <div class="mobile-table">
        <table class="table_not_linked">
            <thead>
            <th>ID</th>
            <th>Название</th>
            <th class="td_small">Начало практики</th>
            <th class="td_small">Окончание практики</th>
            <th class="td_small">Закрыта ли</th>
            </thead>
            <tbody>
                <tr>
                    <td><span class="td_content">{{ $practice->id }}</span></td>
                    <td><span class="td_content">{{ $practice->name }}</span></td>
                    <td class="td_small"><span class="td_content">{{ $practice->start_at }}</span></td>
                    <td class="td_small"><span class="td_content">{{ $practice->end_at }}</span></td>
                    <td class="td_small"><span class="td_content">@if($practice->is_closed)Да@elseНет@endif</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <form method="POST" class="form_main">
        {{ csrf_field() }}
        <div class="errors">
            <p>
                Вы действительно хотите удалить эту практику?
            </p>
        </div>
        <button class="button button_red button_size_normal">Удалить</button>
    </form>
@endsection
