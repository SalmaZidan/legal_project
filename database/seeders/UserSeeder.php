<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Legal user',
            'email' => 'Legal@Legal.com',
            'phone' => '123456789',
            'image' => 'images/user/profile/1.jpg',
            'password' => 'password',
            'type' => 0,

        ]);
    }
}
