<div class="mobile-table">
    <table class="table_not_linked">
        <thead>
        <th>Пользователь</th>
        <th class="td_small">Чат</th>
        <th class="td_small">Последний раз онлайн</th>
        <th class="td_small" colspan="2">Действия</th>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td class="td_linked td_linked_none_padding td_left">
                    <a href="{{ route('profile', $user->id) }}" class="td_content"><div class="td_a_div"><img src="{{ $user->getAvatarFileSrc() }}" alt="Изображение не найдено" class="contact_avatar" /><div class="contact_name">{{ $user->getFullName() }}</div><br/>@if(($user->email != null) && ($user->email != 'Скрыт')){{ $user->email ?? '' }}@if(($user->phone != null) && ($user->phone != 'Скрыт')){{ ', ' }}@endif{{ '' }}@endif{{ '' }}@if(($user->phone != null) && ($user->phone != 'Скрыт')){{ $user->phone ?? '' }}@endif</div></a>
                </td>
                @if($total_user->hasPersonalChatWith($user))
                    <td class="td_small td_linked td_linked_small_padding">
                        <a href="{{ route('chats_view', $total_user->getPersonalChatWith($user)->id) }}" class="td_content">Перейти к личному чату с пользователем</a>
                    </td>
                @else
                    @if($total_user->canCreateChatWith($user))
                        <td class="td_small td_linked td_linked_small_padding">
                            <a href="{{ route('chats_create', $user->id) }}" class="td_content">Создать личный чат с пользователем</a>
                        </td>
                    @else
                        <td class="td_small td_linked_small_padding">
                            <span class="td_content">Пользователь ограничил возможность создания с ним личного чата</span>
                        </td>
                    @endif
                @endif
                <td class="td_small">{{ $user->last_activity_at }}<br/>({{ $user->echoActivityStatus() }})</td>
                <td class="td_small td_linked td_linked_small_padding">
                    @if($total_user->getContactRequestWithUser($user)->is_accepted == true) {{-- Если заявка в контакты между пользователями есть, и она принята --}}
                        <a href="{{ route('contacts_delete', [$user->id, Route::currentRouteName()]) }}" class="td_content">Удалить из контактов</a>
                    @elseif($total_user->getContactRequestWithUser($user)->is_accepted == false) {{-- Если заявка в контакты между пользователями есть, но она не принята --}}
                        @if($total_user->getContactRequestWithUser($user)->user_from->id == $total_user->id) {{-- Если заявка отправлена текущим пользователем --}}
                            <a href="{{ route('contacts_delete', [$user->id, Route::currentRouteName()]) }}" class="td_content">Отменить заявку в контакты</a>
                        @else {{-- Если заявка получена текущим пользователем --}}
                            <a href="{{ route('contacts_create', [$user->id, Route::currentRouteName()]) }}" class="td_content">Принять заявку в контакты</a>
                            <a href="{{ route('contacts_delete', [$user->id, Route::currentRouteName()]) }}" class="td_content">Отклонить заявку в контакты</a>
                        @endif
                    @else {{-- Если заявки в контакты между пользователями нет --}}
                        <a href="{{ route('contacts_create', [$user->id, Route::currentRouteName()]) }}" class="td_content">Добавить в контакты</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
