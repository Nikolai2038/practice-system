<?php

namespace Database\Seeders;

use App\Models\MessageType;
use Illuminate\Database\Seeder;

class MessageTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['Другое', MessageType::MESSAGE_TYPE_WEIGHT_OTHER],
            ['Ответ на задание', MessageType::MESSAGE_TYPE_WEIGHT_TASK_ANSWER],
            ['Вопрос', MessageType::MESSAGE_TYPE_WEIGHT_QUESTION],
            ['Срочный вопрос', MessageType::MESSAGE_TYPE_WEIGHT_QUESTION_IMPORTANT]
        ];

        $number_of_elements = count($data);

        for($i = 0; $i < $number_of_elements; $i++)
        {
            $element = new MessageType;
            $element->name = $data[$i][0];
            $element->weight = $data[$i][1];
            $element->save();
        }
    }
}
