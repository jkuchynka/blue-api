<?php

namespace App\Users\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Users\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('password');
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.org',
            'email_verified_at' => new Carbon,
            'password' => $password
        ]);
        $user->attachRole('admin');

        factory(User::class, 12)->create();
    }
}
