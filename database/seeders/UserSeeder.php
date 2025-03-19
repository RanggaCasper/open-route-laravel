<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'super',
            'email' => 'super@example.com',
            'password' => bcrypt('password'),
            'phone' => '083123456789',
        ])->assignRole('super');
    }
}
