<?php

namespace App\Models;

use App\Http\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
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

    public function canShowEmailTo($user)
    {
        return self::canShowWithSettingValueTo($user->show_email, $user);
    }

    public function canShowPhoneTo($user)
    {
        return self::canShowWithSettingValueTo($user->show_phone, $user);
    }
}
