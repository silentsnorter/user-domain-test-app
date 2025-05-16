<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class DomainService
{
    /**
     * Normalize the domain: remove protocol, 'www', path, and lowercase it.
     *
     * @param string $input
     * @return string
     */
    private function cleanDomain(string $input): string
    {
        $input = trim($input);
        $host = parse_url($input, PHP_URL_HOST);

        if (! $host) {
            $host = parse_url('http://' . $input, PHP_URL_HOST);
        }

        $domain = preg_replace('/^www\./', '', strtolower($host));

        if (! filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            throw new \InvalidArgumentException('Invalid domain format.');
        }

        return $domain;
    }

    /**
     * Create a new domain for the user if it doesn't already exist globally.
     *
     * @param User   $user
     * @param string $rawDomain
     * @return Domain|null
     */
    public function createForUser(User $user, string $rawDomain): ?Domain
    {
        $clean = $this->cleanDomain($rawDomain);

        if (Domain::where('domain', $clean)->exists()) {
            return null;
        }

        return $user->domains()->create([
            'domain' => $clean,
        ]);
    }

    /**
     * Delete the domain if it belongs to the given user.
     *
     * @param User   $user
     * @param Domain $domain
     * @return void
     *
     * @throws AuthorizationException
     */
    public function delete(User $user, Domain $domain): void
    {
        if (! $this->userOwnsDomain($user, $domain)) {
            throw new AuthorizationException('You do not own this domain.');
        }

        $domain->delete();
    }

    /**
     * Check if the domain belongs to the given user.
     *
     * @param User   $user
     * @param Domain $domain
     * @return bool
     */
    public function userOwnsDomain(User $user, Domain $domain): bool
    {
        return $domain->user_id === $user->id;
    }
}
