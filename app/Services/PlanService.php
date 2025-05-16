<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Exception;
use RuntimeException;

class PlanService
{
    /**
     * Assign a plan to the user if it is not already selected.
     *
     * @param User $user
     * @param Plan $plan
     * @return void
     *
     * @throws RuntimeException If the user already has this plan or saving fails.
     */
    public function assignToUser(User $user, Plan $plan): void
    {
        if ($user->plan_id === $plan->id) {
            throw new RuntimeException('You already have this plan.');
        }

        try {
            $user->plan_id = $plan->id;
            $user->save();
        } catch (Exception $e) {
            Log::error('Failed to assign plan: ' . $e->getMessage());

            throw new RuntimeException('Failed to update your plan. Please try again.');
        }
    }
}
