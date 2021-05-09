<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static UsersToPracticesStatus find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string $name
 * @property int $weight
 */
class UsersToPracticesStatus extends Model
{
    use HasFactory;

    // Вес статуса студента на практике (чем больше вес, тем быстрее ему нужно впихнуть чем заниматься)
    public const USERS_TO_PRACTICES_STATUS_WEIGHT_REGISTERED = 4;
    public const USERS_TO_PRACTICES_STATUS_WEIGHT_STARTING = 3;
    public const USERS_TO_PRACTICES_STATUS_WEIGHT_WORKING = 2;
    public const USERS_TO_PRACTICES_STATUS_WEIGHT_FINISHING = 1;
    public const USERS_TO_PRACTICES_STATUS_WEIGHT_CLOSED = 0;

    // АККУРАТНО - ID тут должны совпадать со значениями в БД - пока что будет так
    public const USERS_TO_PRACTICES_STATUS_ID_REGISTERED = 1;
    public const USERS_TO_PRACTICES_STATUS_ID_STARTING = 2;
    public const USERS_TO_PRACTICES_STATUS_ID_WORKING = 3;
    public const USERS_TO_PRACTICES_STATUS_ID_FINISHING = 4;
    public const USERS_TO_PRACTICES_STATUS_ID_CLOSED = 5;

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_to_practices')->withTimestamps();
    }

    public function practices()
    {
        return $this->belongsToMany(Practice::class, 'users_to_practices')->withTimestamps();
    }
}
