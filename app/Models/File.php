<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @method static File find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string name
 * @property string prefix
 * @property string filename
 */
class File extends Model
{
    use HasFactory;

    public function user_from()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->belongsTo(Message::class, 'files_to_messages');
    }

    public function user_avatar()
    {
        return $this->hasOne(User::class);
    }

    public function fileUpload(UploadedFile $file)
    {
        Storage::put(
            $this->prefix,
            file_get_contents($file->getRealPath())
        );
    }

    public function getFilePath()
    {
        return Storage::url($this->filename);
    }

    public function fileDelete()
    {

    }

    public function fileDownload()
    {

    }

   /* public function fileUpload(UploadedFile $file, $folder, $is_public)
    {
        if($is_public)
        {
            $this->prefix = public_path().'/'.$folder;
        }
        else
        {
            $this->prefix = '/files'.'/'.$folder;
        }
        $this->name = $file->getFilename();
        $this->filename = time().'_'.random_bytes(4).'_'.$file->getFilename();
        $file->move($this->prefix, $this->filename);
    }

    public function fileDelete()
    {
        $file = new UploadedFile($this->prefix, $this->filename);
        $file->
    }

    public function fileDownload()
    {
        $file = new UploadedFile($this->prefix, $this->filename);
        return response()->download($file, $name, $headers);
    }*/
}
