<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static UsersToTasksStatus find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string $name
 * @property int $weight
 */
class UsersToTasksStatus extends Model
{
    use HasFactory;

    // Вес статуса выполнения задания студентом (чем больше вес, тем больше студент отстаёт)
    public const USERS_TO_TASKS_STATUS_WEIGHT_RECEIVED = 4;
    public const USERS_TO_TASKS_STATUS_WEIGHT_FAMILIAR = 3;
    public const USERS_TO_TASKS_STATUS_WEIGHT_WORKING = 2;
    public const USERS_TO_TASKS_STATUS_WEIGHT_FINISHED = 2;
    public const USERS_TO_TASKS_STATUS_WEIGHT_SENT = 1;
    public const USERS_TO_TASKS_STATUS_WEIGHT_CHECKING = 1;
    public const USERS_TO_TASKS_STATUS_WEIGHT_ENDED_FAIL = 0; // если есть шанс переделать - студент возвращается на RECEIVED
    public const USERS_TO_TASKS_STATUS_WEIGHT_ENDED_SUCCESS = 0;

    // АККУРАТНО - ID тут должны совпадать со значениями в БД - пока что будет так
    public const USERS_TO_TASKS_STATUS_ID_RECEIVED = 1;
    public const USERS_TO_TASKS_STATUS_ID_FAMILIAR = 2;
    public const USERS_TO_TASKS_STATUS_ID_WORKING = 3;
    public const USERS_TO_TASKS_STATUS_ID_FINISHED = 4;
    public const USERS_TO_TASKS_STATUS_ID_SENT = 5;
    public const USERS_TO_TASKS_STATUS_ID_CHECKING = 6;
    public const USERS_TO_TASKS_STATUS_ID_ENDED_FAIL = 7;
    public const USERS_TO_TASKS_STATUS_ID_ENDED_SUCCESS = 8;

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_to_tasks')->withTimestamps();
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'users_to_tasks')->withTimestamps();
    }
}
