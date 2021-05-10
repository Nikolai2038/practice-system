<?php

namespace App\Models;

use App\Http\Functions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method static User find($id)
 * @method static Builder where(...$params)
 * @method static Builder orderBy
 * @property Carbon $created_at Дата и время создания записи в БД
 * @property Carbon $updated_at Дата и время последнего изменения записи в БД
 * @property Carbon $deleted_at Дата и время мягкого удаления записи в БД
 * @property string $login
 * @property string $password_sha512
 * @property string $first_name
 * @property string $second_name
 * @property string $third_name
 * @property string $email
 * @property int $show_email
 * @property string $phone
 * @property int $show_phone
 * @property Role $role
 * @property Institution $institution
 * @property Carbon $last_activity_at
 */
class User extends Model
{
    use HasFactory;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function bans_from()
    {
        return $this->hasMany(Ban::class);
    }

    public function bans_to()
    {
        return $this->hasMany(Ban::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function practices()
    {
        return $this->belongsToMany(Practice::class, 'users_to_practices')->withTimestamps();
    }

    public function users_to_practices_statuses()
    {
        return $this->belongsToMany(UsersToPracticesStatus::class, 'users_to_practices')->withTimestamps();
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'users_to_chats')->withTimestamps();
    }

    public function tasks_from()
    {
        return $this->hasMany(Task::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'users_to_tasks')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function avatar_file()
    {
        return $this->belongsTo(File::class);
    }

    public function getFullName()
    {
        $full_name = $this->second_name.' '.$this->first_name;
        if($this->third_name != null)
        {
            $full_name .= ' '.$this->third_name;
        }
        return $full_name;
    }

    public function isDirector()
    {
        $user_role_id = $this->role->id;
        return (
            ($user_role_id == Role::ROLE_ID_DIRECTOR_PRACTICE) ||
            ($user_role_id == Role::ROLE_ID_DIRECTOR_STUDY) ||
            ($user_role_id == Role::ROLE_ID_ADMINISTRATOR) ||
            ($user_role_id == Role::ROLE_ID_SUPER_ADMINISTRATOR)
        );
    }

    public function isAdministrator()
    {
        $user_role_id = $this->role->id;
        return (
            ($user_role_id == Role::ROLE_ID_ADMINISTRATOR) ||
            ($user_role_id == Role::ROLE_ID_SUPER_ADMINISTRATOR)
        );
    }

    public function isSuperAdministrator()
    {
        $user_role_id = $this->role->id;
        return ($user_role_id == Role::ROLE_ID_SUPER_ADMINISTRATOR);
    }

    public function hasPermissionOnUser($user)
    {
        return ($this->role->weight > $user->role->weight);
    }

    public function canChangeRoleOfUser($user)
    {
        return (($this->id != $user->id) && ($this->hasPermissionOnUser($user)));
    }

    /** Может ли поменять роль на указанную */
    public function canChangeRoleTo($role)
    {
        return ($role->weight < $this->role->weight); // не может, если роль по весу выше или равна его текущей роли
    }

    public function isOnline()
    {
        return (now()->diffInMinutes($this->last_activity_at) <= 5);
    }

    public function echoActivityStatus()
    {
        if($this->isOnline())
        {
            echo "<span class='online_status'>Онлайн</span>";
        }
        else
        {
            echo "<span class='offline_status'>Оффлайн</span>";
        }
    }

    public function canShowWithSettingValueTo($setting_value, $user)
    {
        if($user == null) // если второй пользователь - гость
        {
            if($setting_value == Functions::SETTING_VALUE_SHOW_TO_ALL) return true;
            else return false;
        }
        else // если второй пользователь - зарегистрированный
        {
            if($user->id == $this->id) // если пользователь смотрит свои поля
            {
                return true;
            }
            else
            {
                $is_in_contacts = true; //!!!!!!!!!!!!!!!!!!!
                if($is_in_contacts)
                {
                    if ($setting_value == Functions::SETTING_VALUE_SHOW_TO_CONTACTS) return true;
                    else return false;
                }
                else
                {
                    if ($setting_value == Functions::SETTING_VALUE_SHOW_TO_ALL) return true;
                    else return false;
                }
            }
        }
    }

    public function canShowEmailTo($user)
    {
        return self::canShowWithSettingValueTo($user->show_email, $user);
    }

    public function canShowPhoneTo($user)
    {
        return self::canShowWithSettingValueTo($user->show_phone, $user);
    }

    public function getAvatarFileSrc()
    {
        if($this->avatar_file == null)
        {
            return '/img/avatar_default.jpg';
        }
        else
        {
            return '';
        }
    }
}
