<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property User $user_from
 * @property User $user_to
 * @property Carbon $unban_at
 */
class Ban extends Model
{
    use HasFactory;

    public function user_from()
    {
        return $this->belongsTo(User::class);
    }

    public function user_to()
    {
        return $this->belongsTo(User::class);
    }
}
