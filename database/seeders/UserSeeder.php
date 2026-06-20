<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@rancabali.com'],
            [
                'name' => 'Superadmin',
                'password' => Hash::make('password')
            ]
        );

        $superAdmin->assignRole('super_admin');

        $admin = User::firstOrCreate(
            ['email' => 'admin@rancabali.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password')
            ]
        );

        $admin->assignRole('admin');
    }
}
