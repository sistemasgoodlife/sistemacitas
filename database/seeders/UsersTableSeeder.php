<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create([
            'name' => 'Bernardo',
            'email' => 'beranrdo@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'cedula' => '5236997',
            'address' => 'Av. america',
            'phone' => '65514402',
            'role' => 'admin',
        ]);        

        User::factory()
            ->count(50)
            ->create();
    }
}
