<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    private $name;
    /**
     * @var mixed
     */
    private $weight;

    public const ROLE_WEIGHT_USER = 0;
    public const ROLE_WEIGHT_DIRECTOR_PRACTICE = 1;
    public const ROLE_WEIGHT_DIRECTOR_STUDY = 1;
    public const ROLE_WEIGHT_ADMINISTRATOR = 2;
    public const ROLE_WEIGHT_SUPER_ADMINISTRATOR = 3;
}
