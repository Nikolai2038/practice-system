<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Practice find
 * @method static Builder where
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
        return $this->belongsToMany(User::class, 'users_to_practices');
    }

    public function users_to_practices_statuses()
    {
        return $this->belongsToMany(UsersToPracticesStatus::class, 'users_to_practices');
    }
}
