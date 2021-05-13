<?php

namespace Database\Seeders;

use App\Http\Functions;
use App\Models\Institution;
use App\Models\Practice;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->login = 'nikolai-415';
        $user->second_name = 'Иванов';
        $user->first_name = 'Николай';
        $user->third_name = 'Александрович';
        $user->password_sha512 = hash('sha512', '342089');
        $user->role()->associate(Role::find(Role::ROLE_ID_SUPER_ADMINISTRATOR));
        $user->institution()->associate(Institution::find(1));
        $user->last_activity_at = now();
        $user->save();

        $data = [
            ['Осипов',      'Артём',        'Андреевич',    'braun.oda@rodriguez.biz',          Role::ROLE_ID_ADMINISTRATOR],
            ['Скворцов',    'Роман',        null,           'astark@hotmail.com',               Role::ROLE_ID_USER],
            ['Лебедев',     'Никита',       'Глебович',     null,                               Role::ROLE_ID_DIRECTOR],
            ['Чернова',     'Александра',   'Ярославовна',  'rice.reese@runolfsdottir.info',    Role::ROLE_ID_USER],
            ['Рябинин',     'Кирилл',       'Ярославович',  null,                               Role::ROLE_ID_USER],
            ['Беляев',      'Марк',         null,           'sasha06@bartell.com',              Role::ROLE_ID_USER],
            ['Павлова',     'Диана',        null,           null,                               Role::ROLE_ID_ADMINISTRATOR],
            ['Нечаев',      'Кирилл',       'Тимофеевич',   'fschuster@pacocha.com',            Role::ROLE_ID_USER],
            ['Осипов',      'Арсений',      'Артёмович',    'ygreenholt@kessler.com',           Role::ROLE_ID_DIRECTOR],
            ['Максимов',     'Игорь',       'Даниилович',   null,                               Role::ROLE_ID_USER],
        ];

        for($i = 0; $i < count($data); $i++)
        {
            $user = new User;
            $user->login = 'user-'.($i + 2);
            $user->first_name = $data[$i][0];
            $user->second_name = $data[$i][1];
            $user->third_name = $data[$i][2];
            $user->email = $data[$i][3];
            $user->show_email = Functions::SETTING_VALUE_ALL;
            $user->show_phone = Functions::SETTING_VALUE_CONTACTS;
            $user->password_sha512 = hash('sha512', '342089');
            $user->role()->associate(Role::find($data[$i][4]));
            $user->last_activity_at = now();
            $user->save();
        }
    }
}
