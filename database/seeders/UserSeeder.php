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
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@jktsweetdessert.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
        ]);

        // Karyawan
        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@jktsweetdessert.com',
            'password' => Hash::make('karyawan123'),
            'role' => 'karyawan',
        ]);

        // User/Customer
        User::create([
            'name' => 'Customer',
            'email' => 'user@jktsweetdessert.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
