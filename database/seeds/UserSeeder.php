<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('password');
        User::create([
            'name' => 'Admin',
            'email' => 'jason.kuchynka@gmail.com',
            'email_verified_at' => new Carbon,
            'password' => $password
        ]);
    }
}
