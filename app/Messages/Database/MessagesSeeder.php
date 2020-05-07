<?php

namespace App\Messages\Database;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Messages\ContactMessage;

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
