<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public const ROLE_WEIGHT_USER = 0;
    public const ROLE_WEIGHT_DIRECTOR_PRACTICE = 1;
    public const ROLE_WEIGHT_DIRECTOR_STUDY = 1;
    public const ROLE_WEIGHT_ADMINISTRATOR = 2;
    public const ROLE_WEIGHT_SUPER_ADMINISTRATOR = 3;

    public const ROLE_ID_USER = 1;
    public const ROLE_ID_DIRECTOR_PRACTICE = 2;
    public const ROLE_ID_DIRECTOR_STUDY = 3;
    public const ROLE_ID_ADMINISTRATOR = 4;
    public const ROLE_ID_SUPER_ADMINISTRATOR = 5;
}
