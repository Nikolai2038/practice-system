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
 * @method static File findOrFail($file_id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string name
 * @property string prefix
 * @property string filename
 * @property string key_sha512
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
        return $this->belongsToMany(Message::class, 'files_to_messages')->withTimestamps();
    }

    public function user_avatar()
    {
        return $this->hasOne(User::class);
    }

    public static function fileCreate(UploadedFile $file, string $prefix, User $user_from)
    {
        $db_file = new File;
        $db_file->name = $file->getClientOriginalName();
        $db_file->prefix = $prefix;
        $db_file->filename = hash('sha512', time().'_'.$user_from->id.'_'.random_int(1000, 9999).'_'.$db_file->name).'.'.$file->getClientOriginalExtension();
        $db_file->user_from()->associate($user_from);
        Storage::disk('public')->put(
            $db_file->prefix.'/'.$db_file->filename,
            file_get_contents($file->getRealPath())
        );
        $db_file->save();
        return $db_file;
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
        try
        {
            return Storage::download($this->prefix . '/' . $this->filename, $this->name);
        }
        catch (\Exception $exception)
        {
            return 'Файл сейчас скачается...';
        }
    }
}
