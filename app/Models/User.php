<?php

namespace App\Models;

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
        return $this->second_name.' '.$this->first_name.' '.$this->third_name;
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
}
