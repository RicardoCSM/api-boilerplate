<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('login', 'admin')->first();

        if ($user) {
            $user->update([
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]);
        } else {
            $user = User::create([
                'name' => 'Admin',
                'login' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        $user = User::where('login', 'user')->first();

        if ($user) {
            $user->update([
                'name' => 'User',
                'password' => Hash::make('password'),
            ]);
        } else {
            User::create([
                'name' => 'User',
                'login' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
