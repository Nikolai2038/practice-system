<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @method static ChatType find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string $name
 * @property HasMany $chats
 */
class ChatType extends Model
{
    use HasFactory;

    // АККУРАТНО - ID тут должны совпадать со значениями в БД - пока что будет так
    public const CHAT_TYPE_ID_PERSONAL = 1;
    public const CHAT_TYPE_ID_PRACTIC = 2;
    public const CHAT_TYPE_ID_TASK = 3;

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
