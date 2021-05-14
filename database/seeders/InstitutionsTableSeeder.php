<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\InstitutionType;
use Illuminate\Database\Seeder;

class InstitutionsTableSeeder extends Seeder
{
    public function run()
    {
        /*for($i = 1; $i <= 30; $i++)
        {
            $institution = new Institution;
            $institution->full_name = 'Полное_название_'.$i;
            $institution->short_name = 'Краткое_название_'.$i;
            $institution->address = 'Адрес_'.$i;
            $institution->institution_type()->associate(InstitutionType::find($i % 2 + 1));
            $institution->save();
        }*/
    }
}
