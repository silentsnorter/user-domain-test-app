<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::pluck('id')->toArray();

        User::factory()->count(24)->create()->each(function($user) use ($plans) {
            $user->update([
                'plan_id' => collect($plans)->random(),
            ]);
        });
    }
}
