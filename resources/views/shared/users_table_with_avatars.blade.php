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
                <td class="td_linked td_none_padding td_left">
                    <a href="{{ route('profile', $user->id) }}" class="td_content"><div class="td_a_div"><img src="{{ $user->getAvatarFileSrc() }}" alt="Изображение не найдено" class="contact_avatar" /><div class="contact_name">{{ $user->getFullName() }}</div><br/>@if(($user->email != null) && ($user->email != 'Скрыт')){{ $user->email ?? '' }}@if(($user->phone != null) && ($user->phone != 'Скрыт')){{ ', ' }}@endif{{ '' }}@endif{{ '' }}@if(($user->phone != null) && ($user->phone != 'Скрыт')){{ $user->phone ?? '' }}@endif</div></a>
                </td>
                @if($total_user->hasPersonalChatWith($user))
                    <td class="td_small td_linked td_small_padding">
                        <a href="{{ route('chats_view', $total_user->getPersonalChatWith($user)->id) }}" class="td_content">Перейти к личному чату с пользователем</a>
                    </td>
                @else
                    @if($total_user->canCreateChatWith($user))
                        <td class="td_small td_linked td_small_padding">
                            <a href="{{ route('chats_create', $user->id) }}" class="td_content">Создать личный чат с пользователем</a>
                        </td>
                    @else
                        <td class="td_small td_small_padding">
                            @if($total_user->id == $user->id)
                                    <span class="td_content">-</span>
                            @else
                                    <span class="td_content">Пользователь ограничил возможность создания с ним личного чата</span>
                            @endif
                        </td>
                    @endif
                @endif
                <td class="td_small td_none_padding">{{ $user->last_activity_at }}<br/>({{ $user->echoActivityStatus() }})</td>
                @if($total_user->id == $user->id)
                    <td class="td_small">-</td>
                @else
                    <td class="td_small td_linked td_small_padding">
                        @php
                            $redirect_route_name = Route::currentRouteName();
                            $redirect_route_params = [$user->id, $redirect_route_name];
                            $redirect_route_params_GET = array();
                            if($practice ?? null != null)
                            {
                                $redirect_route_params_GET[] = $practice->id;
                            }
                            $redirect_route_params = array_merge($redirect_route_params, $redirect_route_params_GET);
                        @endphp
                        @if($total_user->getContactRequestWithUser($user) == null) {{-- Если заявки в контакты между пользователями нет --}}
                            <a href="{{ route('contacts_create', $redirect_route_params) }}" class="td_content">Добавить в контакты</a>
                        @else
                            @if($total_user->getContactRequestWithUser($user)->is_accepted == true) {{-- Если заявка в контакты между пользователями есть, и она принята --}}
                                <a href="{{ route('contacts_delete', $redirect_route_params) }}" class="td_content">Удалить из контактов</a>
                            @else {{-- Если заявка в контакты между пользователями есть, но она не принята --}}
                                @if($total_user->getContactRequestWithUser($user)->user_from->id == $total_user->id) {{-- Если заявка отправлена текущим пользователем --}}
                                    <a href="{{ route('contacts_delete', $redirect_route_params) }}" class="td_content">Отменить заявку в контакты</a>
                                @else {{-- Если заявка получена текущим пользователем --}}
                                    <a href="{{ route('contacts_create', $redirect_route_params) }}" class="td_content">Принять заявку в контакты</a>
                                    {{-- <a href="{{ route('contacts_delete', $redirect_route_params) }}" class="td_content">Отклонить заявку в контакты</a> --}}
                                @endif
                            @endif
                        @endif
                    </td>
                @endif
                @if(($practice ?? null) != null)
                    @if($total_user->hasPermissionOnPractice($practice))
                        @if($total_user->id == $user->id)
                            <td class="td_small">-</td>
                        @else
                            <td class="td_small td_linked td_small_padding">
                                <a href="{{ route('practices_remove_user', [$practice->id, $user->id]) }}" class="td_content">Удалить с практики</a>
                            </td>
                        @endif
                    @endif
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(is_array($users) == false)
    {{ $users->links('shared.pagination') }}
@endif
