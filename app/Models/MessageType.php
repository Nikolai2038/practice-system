<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @method static MessageType find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string $name
 * @property HasMany $messages
 */
class MessageType extends Model
{
    use HasFactory;

    // АККУРАТНО - ID тут должны совпадать со значениями в БД - пока что будет так
    public const MESSAGE_TYPE_ID_OTHER = 1;
    public const MESSAGE_TYPE_ID_TASK_ANSWER = 2;
    public const MESSAGE_TYPE_ID_QUESTION = 3;
    public const MESSAGE_TYPE_ID_QUESTION_IMPORTANT = 4;

    public const MESSAGE_TYPE_WEIGHT_OTHER = 0;
    public const MESSAGE_TYPE_WEIGHT_TASK_ANSWER = 1;
    public const MESSAGE_TYPE_WEIGHT_QUESTION = 2;
    public const MESSAGE_TYPE_WEIGHT_QUESTION_IMPORTANT = 3;

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
