document.body.onkeydown = function(event) {
    var e = event || window.event;
    var code = e.keyCode || e.which;
    var activeEl = document.activeElement.id;
    if(!(code === 13 && e.shiftKey))
    {
        if (code === 13 && e.ctrlKey)
        {
            if ((activeEl === "textarea"))
            {
                document.getElementById('textarea').value += "\n";
            }
            else
            {
                return false;
            }
        }
        else if (code === 13 && activeEl === "textarea")
        {
            var textarea = document.getElementById('textarea').value;
            textarea = textarea.replace(/^\s+/, "");
            if (textarea !== "")
            {
                submitForm();
            }
            return false;
        }
    }
}
