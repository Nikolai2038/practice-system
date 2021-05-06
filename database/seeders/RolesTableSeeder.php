<?php

namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // название роли - вес (чем больше вес, тем больше прав)
        $data = [
            ['Пользователь', Role::ROLE_WEIGHT_USER],
            ['Руководитель от предприятия', Role::ROLE_WEIGHT_DIRECTOR_PRACTICE],
            ['Руководитель от учебного заведения', Role::ROLE_WEIGHT_DIRECTOR_STUDY],
            ['Администратор', Role::ROLE_WEIGHT_ADMINISTRATOR],
            ['Главный администратор', Role::ROLE_WEIGHT_SUPER_ADMINISTRATOR]
        ];

        $roles_number = count($data);

        for($i = 0; $i < $roles_number; $i++)
        {
            $role = new Role;
            $role->name = $data[$i][0];
            $role->weight = $data[$i][1];
            $role->save();
        }
    }
}
