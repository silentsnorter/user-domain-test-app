<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Models\Domain;
use App\Services\DomainService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DomainController extends Controller
{
    public function __construct(private readonly DomainService $domainService)
    {
    }

    /**
     * Show the dashboard with all domains for the authenticated user.
     *
     * @return View
     */
    public function dashboard(): View
    {
        $domains = Auth::user()->domains;

        return view('domain.dashboard', compact('domains'));
    }

    /**
     * Store a new domain for the authenticated user.
     *
     * @param StoreDomainRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDomainRequest $request): RedirectResponse
    {
        try {
            $domain = $this->domainService->createForUser(
                Auth::user(),
                $request->input('domain')
            );

            if (! $domain) {
                return back()->withErrors([
                    'domain' => 'This domain already exists.',
                ]);
            }

            return back()->with('success', 'Domain added successfully.');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors([
                'domain' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            Log::error('Domain creation error: ' . $e->getMessage());

            return back()->withErrors([
                'domain' => 'Something went wrong.',
            ]);
        }
    }

    /**
     * Delete the specified domain if it belongs to the authenticated user.
     *
     * @param Domain $domain
     * @return RedirectResponse
     */
    public function delete(Domain $domain): RedirectResponse
    {
        try {
            $this->domainService->delete(Auth::user(), $domain);

            return back()->with('success', 'Domain deleted successfully.');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return back()->withErrors([
                'domain' => 'You are not authorized to delete this domain.',
            ]);
        } catch (\Exception $e) {
            Log::error('Domain deletion error: ' . $e->getMessage());

            return back()->withErrors([
                'domain' => 'Failed to delete domain. Please try again.',
            ]);
        }
    }

    // TODO: Implement domain update functionality if needed.
}
