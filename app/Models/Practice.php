<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Practice find($id)
 * @method static Practice findOrFail($param)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string $name
 * @property string $description
 * @property User $user_from
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property boolean $is_closed
 * @property string $registration_key
 * @property Carbon $registration_closed_at;
 */
class Practice extends Model
{
    use HasFactory;

    public function user_from()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_to_practices')->withTimestamps();
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function users_to_practices_statuses()
    {
        return $this->belongsToMany(UsersToPracticesStatus::class, 'users_to_practices')->withTimestamps();
    }

    public static function generateRandomRegistrationKey()
    {
        return hash('sha256', random_int(1, 999999999)).hash('sha256', time());
    }

    /**
     * @return Chat
    */
    public function getPracticeMainChatOrFail()
    {
        return $this->chats()->where('task_id', '=', null)->firstOrFail();
    }
}
