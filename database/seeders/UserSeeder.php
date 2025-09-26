<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $seller = User::create([
        'name' => 'Seller User',
        'email' => 'seller@example.com',
        'password' => bcrypt('password'),
    ]);
    $seller->assignRole('seller');

    $buyer = User::create([
        'name' => 'Buyer User',
        'email' => 'buyer@example.com',
        'password' => bcrypt('password'),
    ]);
    $buyer->assignRole('buyer');
}
}
