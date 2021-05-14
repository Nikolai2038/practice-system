<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\ChatType;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$chat = new Chat;
        $chat->chat_type()->associate(ChatType::find(ChatType::CHAT_TYPE_ID_PERSONAL));
        $chat->save();
        $chat->users()->attach(User::find(1));
        $chat->users()->attach(User::find(2));*/
    }
}
