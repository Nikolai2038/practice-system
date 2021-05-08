<?php

namespace Database\Seeders;

use App\Models\InstitutionType;
use Illuminate\Database\Seeder;

class InstitutionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institution_type_1 = new InstitutionType;
        $institution_type_1->name = 'Предприятие';
        $institution_type_1->save();

        $institution_type_2 = new InstitutionType;
        $institution_type_2->name = 'Учебное заведение';
        $institution_type_2->save();
    }
}
