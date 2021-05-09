<?php

namespace Database\Seeders;

use App\Models\ChatType;
use Illuminate\Database\Seeder;

class ChatTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chat_type = new ChatType;
        $chat_type->name = 'Чат практики';
        $chat_type->save();

        $chat_type = new ChatType;
        $chat_type->name = 'Чат задания';
        $chat_type->save();

        $chat_type = new ChatType;
        $chat_type->name = 'Личный чат';
        $chat_type->save();
    }
}
