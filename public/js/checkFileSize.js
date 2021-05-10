function checkFileSize(max_file_size_mb)
{
    const input = document.getElementById("upload");
    if(input.files && input.files.length == 1)
    {
        if (input.files[0].size > max_file_size_mb * 1024 * 1024)
        {
            alert("Максимальный размер файла: " + (max_file_size_mb) + " мб!");
            return false;
        }
    }
    return true;
}
