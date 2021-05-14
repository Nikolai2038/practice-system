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
        /*$data = [
            [2, 3, false, new Carbon("2021-05-11 00:00:00")],
            [8, 8, false, new Carbon("2021-05-29 00:00:00")],
            [2, 8, true, null],
        ];

        for($i = 0; $i < count($data); $i++)
        {
            $ban = new Ban;
            $ban->user_from()->associate(User::find($data[$i][0]));
            $ban->user_to()->associate(User::find($data[$i][1]));
            $ban->is_permanent = $data[$i][2];
            $ban->unban_at = $data[$i][3];
            $ban->save();
        }*/
    }
}
