<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@deboracraft.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Test',
            'email' => 'user@deboracraft.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->command->info('Users created successfully!');
        $this->command->info('Admin: admin@deboracraft.com / password');
        $this->command->info('User: user@deboracraft.com / password');
    }
}
