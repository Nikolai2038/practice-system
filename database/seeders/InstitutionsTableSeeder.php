<?php

namespace Database\Seeders;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class InstitutionsTableSeeder extends Seeder
{
    public function run()
    {
        for($i = 1; $i <= 30; $i++)
        {
            $institution = new Institution;
            $institution->full_name = 'Полное_название_'.$i;
            $institution->short_name = 'Краткое_название_'.$i;
            $institution->address = 'Адрес_'.$i;
            $institution->type_id = $i % 2;
            $institution->save();
        }
    }
}
