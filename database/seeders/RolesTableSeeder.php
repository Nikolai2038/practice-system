<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Пользователь', Role::ROLE_WEIGHT_USER],
            ['Руководитель', Role::ROLE_WEIGHT_DIRECTOR],
            ['Администратор', Role::ROLE_WEIGHT_ADMINISTRATOR],
            ['Главный администратор', Role::ROLE_WEIGHT_SUPER_ADMINISTRATOR]
        ];

        $number_of_elements = count($data);

        for($i = 0; $i < $number_of_elements; $i++)
        {
            $element = new Role;
            $element->name = $data[$i][0];
            $element->weight = $data[$i][1];
            $element->save();
        }
    }
}
