<?php

namespace Database\Seeders;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 5; $i <= 19; $i++)
        {
            $ban = new Ban;
            $ban->user_from()->associate(User::find(1));
            $ban->user_to()->associate(User::find($i));
            $ban->unban_at = new Carbon("2021-05-".random_int(0, 2).random_int(1, 9)." 00:00:00");
            $ban->save();
        }
    }
}
