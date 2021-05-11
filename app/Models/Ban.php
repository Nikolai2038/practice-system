<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Ban find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property User $user_from
 * @property User $user_to
 * @property boolean $is_permanent
 * @property Carbon $unban_at
 * @property string $description
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

    public function isActive()
    {
        if($this->is_permanent)
        {
            return true;
        }
        else
        {
            $unban_at = new Carbon($this->unban_at);
            return $unban_at->greaterThan(now());
        }
    }
}
