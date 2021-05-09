<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\User;
use App\Models\UsersToPracticesStatus;
use Illuminate\Database\Seeder;

class UsersToPracticesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::find(1)->practices()->attach(Practice::find(1), ['users_to_practices_status_id' => UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_ID_REGISTERED]);
    }
}
