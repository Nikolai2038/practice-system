<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->login = 'admin';
        $user->first_name = 'Главный';
        $user->second_name = 'Администратор';
        $user->password_sha512 = 'd4c7cbe840c6978ac6460ee7a9ad4120c72de114846046bffc81fd0b5517bc0e17dd0b1ffaafebc13a8d3525b54c8350124eac9a5df414f19cbfb976b944aabc';
        $user->role_id = Role::ROLE_ID_SUPER_ADMINISTRATOR;
        $user->last_activity_at = now();
        $user->save();
    }
}
