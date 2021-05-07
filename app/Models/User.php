<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function getFullName()
    {
        return $this->second_name.' '.$this->first_name.' '.$this->third_name;
    }
}
