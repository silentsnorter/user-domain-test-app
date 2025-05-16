<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminExists = \App\Models\User::where('email', 'admin@example.com')->exists();

        if ($adminExists) {
            $this->command->info('Admin user already exists, skipping creation.');
            return;
        }

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
            'plan_id' => null
        ]);
    }
}
