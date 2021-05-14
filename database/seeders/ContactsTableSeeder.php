<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$contact = new Contact();
        $contact->user_from()->associate(User::find(1));
        $contact->user_to()->associate(User::find(2));
        $contact->is_accepted = true;
        $contact->save();

        $contact = new Contact();
        $contact->user_from()->associate(User::find(1));
        $contact->user_to()->associate(User::find(3));
        $contact->is_accepted = true;
        $contact->save();

        $contact = new Contact();
        $contact->user_from()->associate(User::find(1));
        $contact->user_to()->associate(User::find(4));
        $contact->is_accepted = false;
        $contact->save();*/
    }
}
