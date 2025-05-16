<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function __construct(
        private readonly PlanService $planService
    ) {
    }

    /**
     * Display all available plans.
     *
     * @return View
     */
    public function index(): View
    {
        $plans = Plan::all();

        return view('plan.index', compact('plans'));
    }

    /**
     * Assign the selected plan to the authenticated user.
     *
     * @param Plan $plan
     * @return RedirectResponse
     */
    public function buy(Plan $plan): RedirectResponse
    {
        try {
            $this->planService->assignToUser(auth()->user(), $plan);

            return redirect()
                ->route('plans')
                ->with('success', 'Plan updated successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('plans')
                ->withErrors(['plan' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error('Unexpected plan update error: ' . $e->getMessage());

            return redirect()
                ->route('plans')
                ->withErrors(['plan' => 'Something went wrong while updating your plan.']);
        }
    }
}
