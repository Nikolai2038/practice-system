<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @method static Role find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string $name
 * @property int $weight
 * @property HasMany $users
 */
class Role extends Model
{
    use HasFactory;

    // Вес роли (чем больше вес, тем больше прав)
    public const ROLE_WEIGHT_USER = 0;
    public const ROLE_WEIGHT_DIRECTOR = 1;
    public const ROLE_WEIGHT_ADMINISTRATOR = 2;
    public const ROLE_WEIGHT_SUPER_ADMINISTRATOR = 3;

    // АККУРАТНО - ID тут должны совпадать со значениями в БД - пока что будет так
    public const ROLE_ID_USER = 1;
    public const ROLE_ID_DIRECTOR = 2;
    public const ROLE_ID_ADMINISTRATOR = 3;
    public const ROLE_ID_SUPER_ADMINISTRATOR = 4;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
