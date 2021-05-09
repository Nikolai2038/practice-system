<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Message find
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string text
 */
class Message extends Model
{
    use HasFactory;

    public function user_from()
    {
        return $this->belongsTo(User::class);
    }

    public function message_type()
    {
        return $this->belongsTo(Message::class);
    }

    public function files()
    {
        return $this->hasMany(File::class, 'files_to_messages')->withTimestamps();
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'messages_to_chats')->withTimestamps();
    }
}
