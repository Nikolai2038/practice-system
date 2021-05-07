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

        for($i = 2; $i <= 500; $i++)
        {
            $user = new User;
            $user->login = 'user-'.$i;
            $user->first_name = 'Имя_'.$i;
            $user->second_name = 'Фамилия_'.$i;
            $user->third_name = 'Отчество_'.$i;
            $user->email = 'user-'.$i.'@email.com';
            $user->password_sha512 = 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db';
            $user->role_id = Role::ROLE_ID_USER;
            $user->last_activity_at = now();
            $user->save();
        }
    }
}
