<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $plan_name
 * @property int $price
 * @property array $features
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 */
class Plan extends Model
{
    protected $fillable = ['plan_name', 'price', 'features'];

    protected $casts = [
        'features' => 'array',
    ];

    /**
     * Get all users subscribed to this plan.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
