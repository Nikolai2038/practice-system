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
        $institution_type = new InstitutionType;
        $institution_type->name = 'Предприятие';
        $institution_type->save();

        $institution_type = new InstitutionType;
        $institution_type->name = 'Учебное заведение';
        $institution_type->save();
    }
}
