<?php

namespace Database\Seeders;

use App\Models\UsersToPracticesStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Необходимые сидеры для работы системы - не удалять
        $this->call(InstitutionTypesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersToPracticesStatusesTableSeeder::class);
        $this->call(ChatTypesTableSeeder::class);
        $this->call(UsersToTasksStatusesTableSeeder::class);
        $this->call(MessageTypesTableSeeder::class);

        // Сидеры для тестирования - можно удалить, только в сидере с пользователями оставить запись главного администратора
        $this->call(InstitutionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BansTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(PracticesTableSeeder::class);
        $this->call(ChatsTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(FilesTableSeeder::class);

        // Тоже тестирование - промежуточные таблицы между связями многие ко многим - идут в конце, чтобы все необходимые таблицы к этому моменту уже были созданы
        $this->call(UsersToPracticesTableSeeder::class);
        $this->call(UsersToChatsTableSeeder::class);
        $this->call(UsersToTasksTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(FilesTableSeeder::class);
    }
}
