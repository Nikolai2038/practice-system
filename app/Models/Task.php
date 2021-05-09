<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Task find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 */
class Task extends Model
{
    use HasFactory;

    public function user_from()
    {
        return $this->belongsTo(User::class);
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_to_tasks')->withTimestamps();
    }

    public function users_to_tasks_statuses()
    {
        return $this->belongsToMany(UsersToTasksStatus::class, 'users_to_tasks')->withTimestamps();
    }
}
