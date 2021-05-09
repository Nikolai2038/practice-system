<?php

namespace Database\Seeders;

use App\Models\UsersToTasksStatus;
use Illuminate\Database\Seeder;

class UsersToTasksStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Вес статуса выполнения задания студентом (чем больше вес, тем больше студент отстаёт)
        $data = [
            ['Получил', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_RECEIVED],
            ['Ознакомлен', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_FAMILIAR],
            ['Выполняет', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_WORKING],
            ['Закончил', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_FINISHED],
            ['Отправил', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_SENT],
            ['Проверяется руководителем', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_CHECKING],
            ['Выполнено', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_ENDED_FAIL],
            ['Провалено', UsersToTasksStatus::USERS_TO_TASKS_STATUS_WEIGHT_ENDED_SUCCESS]
        ];

        $number_of_elements = count($data);

        for($i = 0; $i < $number_of_elements; $i++)
        {
            $element = new UsersToTasksStatus;
            $element->name = $data[$i][0];
            $element->weight = $data[$i][1];
            $element->save();
        }
    }
}
