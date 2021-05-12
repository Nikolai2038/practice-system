<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Chat find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @method static findOrFail(int $param)
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 */
class Chat extends Model
{
    use HasFactory;

    public function chat_type()
    {
        return $this->belongsTo(ChatType::class);
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_to_chats')->withTimestamps();
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'messages_to_chats');
    }

    public function getSecondUserIfChatIsPersonal($first_user)
    {
        if($this->chat_type->id == ChatType::CHAT_TYPE_ID_PERSONAL)
        {
            return $this->users()->where('users.id', '!=', $first_user->id)->first();
        }
        else
        {
            return null;
        }
    }
}
