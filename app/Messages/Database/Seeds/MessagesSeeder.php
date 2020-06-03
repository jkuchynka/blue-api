<?php

namespace App\Messages\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Messages\Models\ContactMessage;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ContactMessage::class, 12)->create();
    }
}
