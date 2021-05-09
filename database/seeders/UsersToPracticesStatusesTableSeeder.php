<?php

namespace Database\Seeders;

use App\Models\UsersToPracticesStatus;
use Illuminate\Database\Seeder;

class UsersToPracticesStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // название статуса студента на практике - вес (чем больше вес, тем больше прав)
        $data = [
            ['Зарегистрирован на практику', UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_WEIGHT_REGISTERED],
            ['Начинает практику', UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_WEIGHT_STARTING],
            ['На практике', UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_WEIGHT_WORKING],
            ['Заканчивает практику', UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_WEIGHT_FINISHING],
            ['Закончил практику', UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_WEIGHT_CLOSED]
        ];

        $number_of_elements = count($data);

        for($i = 0; $i < $number_of_elements; $i++)
        {
            $element = new UsersToPracticesStatus;
            $element->name = $data[$i][0];
            $element->weight = $data[$i][1];
            $element->save();
        }
    }
}
