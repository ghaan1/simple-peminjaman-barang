<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'name' => "Admin Kelurahan",
            'email' => "superadmin@gmail.com",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => "Admin RT",
            'email' => "user@gmail.com",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => "RT1",
            'email' => "rt1@gmail.com",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => "RT2",
            'email' => "rt2@gmail.com",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => "RT3",
            'email' => "rt3@gmail.com",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
