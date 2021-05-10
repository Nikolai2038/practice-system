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
        Storage::disk('public')->put(
            $this->prefix.'/'.$this->filename,
            file_get_contents($file->getRealPath())
        );
    }

    public function getFileUrl()
    {
        return Storage::disk('public')->url($this->prefix.'/'.$this->filename);
    }

    public function fileDelete()
    {
        return Storage::disk('public')->delete($this->prefix.'/'.$this->filename);
    }

    public function fileDownload()
    {

    }
}
