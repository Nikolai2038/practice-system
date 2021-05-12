@extends('shared.layout')

@section('title', $chat->name ?? 'Личный чат с пользователем '.$chat->getSecondUserIfChatIsPersonal($total_user)->getFullName())

@section('css')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('css/tables.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/chat.css') }}" type="text/css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('page_sized_class', 'big_page')

@section('page_title', $chat->name ?? 'Личный чат с пользователем '.$chat->getSecondUserIfChatIsPersonal($total_user)->getFullName())

@section('sub_menu')
    @if($chat->chat_type->id == App\Models\ChatType::CHAT_TYPE_ID_PERSONAL)
        <a href="{{ route('chats') }}" class="button button_blue button_size_small">Вернуться к списку личных чатов</a>
        <a href="{{ route('chats_delete', $chat->getSecondUserIfChatIsPersonal($total_user)->id) }}" class="button button_blue button_size_small">Удалить личный чат с пользователем</a>
    @else
    @endif
@endsection

@section('content')
    <div class="chat_container">
        <div class="chat_messages">
        </div>
        <form id="contactform" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <span class="success">Чат загружается...</span>
            <span class="failure"></span><br/>
            <textarea name="message_text" class="form-control" placeholder="Введите сообщение" rows="3" id="textarea" disabled autofocus></textarea>
            <span class="text-danger" id="messageError"></span>
            <button type="button" class="btn btn-success save-data" onclick="submitForm()" id="button" disabled>Отправить</button>
            <input type="file" name="uploaded[]" id="files" disabled multiple />
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        var messages = null;
        var messages_created_at = null;
        var messages_users = null;
        var messages_users_avatars = null;
        var messages_users_onlines = null;
        var messages_files = null;

        var is_sending = false;
        var is_checking = false;

        setInterval(loadChat, 5000);
        async function submitForm()
        {
            is_sending = true;
            try
            {
                $('.failure').text('');
                $('.success').text('Идёт отправка...');
                document.getElementById("textarea").toggleAttribute('disabled', true);
                document.getElementById("button").toggleAttribute('disabled', true);
                document.getElementById("files").toggleAttribute('disabled', true);
                //console.log('Начало отправки сообщения.');

                let message_text = $("textarea[name=message_text]").val();
                let _token = $('meta[name="csrf-token"]').attr('content');
                //let files = document.getElementById('files').prop('files');

                //var files = document.getElementById("files").prop('files')[0];
                var formData = new FormData();
                $.each($("#files")[0].files,function(key, input){
                    formData.append('uploaded[]', input);
                });
                formData.append('message_text', message_text);
                formData.append('_token', _token);
                //formData.append('uploaded', files);

                await $.ajax({
                    url: "/chats/{{ $chat->id }}",
                    type: "POST",
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response)
                    {
                        //console.log('Ответ получен.');
                        if(response === undefined) throw new Error("Данные неполны: нет имени");
                        let data = JSON.parse(response);
                        if (response)
                        {
                            messages = data.messages;
                            messages_users = data.messages_users;
                            messages_users_avatars = data.messages_users_avatars;
                            messages_users_onlines = data.messages_users_onlines;
                            messages_files = data.messages_files;
                            messages_created_at = data.messages_created_at;
                            loadMessages();
                        }
                    },
                    error: function (response)
                    {
                        console.log(response.responseJSON.errors);
                    }
                });
            }
            catch (e)
            {
                $('.failure').text('При отправке сообщения произошла ошибка.');
            }
            finally
            {
                //console.log('Конец отправки сообщения.');

                $("#contactform")[0].reset();
                document.getElementById("button").toggleAttribute('disabled', false);
                document.getElementById("textarea").toggleAttribute('disabled', false);
                document.getElementById("files").toggleAttribute('disabled', false);
                $('.success').text('');
                is_sending = false;
                document.getElementById("textarea").focus();
            }
        }
        async function loadChat()
        {
            if((is_sending === false) && (is_checking === false))
            {
                is_checking = true;
                try
                {
                    $('.failure').text('');
                    //console.log('Начало проверки чата.');
                    let _token = $('meta[name="csrf-token"]').attr('content');
                    await $.ajax({
                        url: "/chats/{{ $chat->id }}",
                        type: "POST",
                        data: {
                            message_text: null,
                            _token: _token
                        },
                        success: function (response)
                        {
                            //console.log('Ответ 2 получен.');
                            if(response === undefined) throw new Error("Данные неполны: нет имени");
                            let data = JSON.parse(response);
                            if (response)
                            {
                                let new_messages = data.messages;
                                let new_messages_users = data.messages_users;
                                let new_messages_users_avatars = data.messages_users_avatars;
                                let new_messages_users_onlines = data.messages_users_onlines;
                                let new_messages_files = data.messages_files;
                                let new_messages_created_at = data.messages_created_at;
                                if ((messages === null) || (new_messages.toString() !== messages.toString()))
                                {
                                    //console.log('Чат нужно обновить.');
                                    messages = new_messages;
                                    messages_users = new_messages_users;
                                    messages_users_avatars = new_messages_users_avatars;
                                    messages_users_onlines = new_messages_users_onlines;
                                    messages_files = new_messages_files;
                                    messages_created_at = new_messages_created_at;
                                    loadMessages();
                                }
                                else
                                {
                                    //console.log('Чат не нужно обновлять.');
                                }
                            }
                        },
                        error: function (response)
                        {
                            console.log(response.responseJSON.errors);
                        }
                    });
                }
                catch (e)
                {
                    $('.failure').text('При проверке чата произошла ошибка.');
                }
                finally
                {
                    //console.log('Конец проверки чата.');
                    document.getElementById("button").toggleAttribute('disabled', false);
                    document.getElementById("textarea").toggleAttribute('disabled', false);
                    document.getElementById("files").toggleAttribute('disabled', false);
                    is_checking = false;
                    document.getElementById("textarea").focus();
                }
            }
        }
        function loadMessages()
        {
            //console.log('Начало обновления чата.');
            var frame_doc = "";
            if(messages.length === 0)
            {
                frame_doc = "Нет сообщений!";
            }
            else
            {
                for (var index = 0; index < messages.length; ++index)
                {
                    let user_from_id = messages[index].user_from_id;
                    frame_doc += "<div class=\"message ";
                    if(user_from_id == {{ $total_user->id }})
                    {
                        frame_doc += "message_right";
                    }
                    else
                    {
                        frame_doc += "message_left";
                    }
                    frame_doc += "\">";
                    frame_doc += "<div class=\"created_at\">";
                    frame_doc += messages_created_at[index];
                    frame_doc += "</div>";
                    frame_doc += "<div class=\"message_avatar\">";
                    frame_doc += "<a href=\"/users/" + user_from_id + "/profile\">";
                    frame_doc += "<img src=\"";
                    frame_doc += messages_users_avatars[user_from_id];
                    frame_doc += "\" alt=\"Изображение не найдено\"";
                    if(messages_users_onlines[user_from_id] == true)
                    {
                        frame_doc += " class=\"img_online\"";
                    }
                    frame_doc += "/>";
                    frame_doc += "</a>";
                    frame_doc += "</div>";
                    frame_doc += "<div class=\"name\">";
                    if(messages_users[user_from_id].third_name == null)
                    {
                        frame_doc += messages_users[user_from_id].first_name + " " + messages_users[user_from_id].second_name;
                    }
                    else
                    {
                        frame_doc += messages_users[user_from_id].second_name + " " + messages_users[user_from_id].first_name + " " + messages_users[user_from_id].third_name;
                    }
                    frame_doc += "</div>";
                    frame_doc += "<div class=\"text\">";
                    frame_doc += messages[index].text;
                    if(messages_files[index].length > 0)
                    {
                        frame_doc += "<br/><span class=\"files\">";
                        messages_files[index].forEach(function (item, i, arr)
                        {
                            frame_doc += item.name + "; ";
                        });
                        frame_doc += "</span>";
                    }
                    frame_doc += "</div>";
                    frame_doc += "</div>";
                }
            }
            var el = document.getElementsByClassName("chat_messages")[0];
            el.innerHTML = frame_doc;
            el.scrollTop = el.scrollHeight;
            $('.success').text('');
            //console.log('Конец обновления чата.');
        }
        document.body.onkeydown = function(event) {
            var e = event || window.event;
            var code = e.keyCode || e.which;
            var activeEl = document.activeElement.id;
            if(!(code == 13 && e.shiftKey))
            {
                if (code == 13 && e.ctrlKey)
                {
                    if ((activeEl == "textarea"))
                    {
                        document.getElementById('textarea').value += "\n";
                    }
                    else
                    {
                        return false;
                    }
                }
                else if (code == 13 && activeEl == "textarea")
                {
                    var textarea = document.getElementById('textarea').value;
                    textarea = textarea.replace(/^\s+/, "");
                    if (textarea != "")
                    {
                        submitForm();
                    }
                    return false;
                }
            }
        }
    </script>
@endsection
