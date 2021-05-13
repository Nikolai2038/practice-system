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
