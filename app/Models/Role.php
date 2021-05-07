<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany('App\Models\User');
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
