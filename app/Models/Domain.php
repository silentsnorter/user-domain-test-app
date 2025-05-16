<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $domain
 * @property-read User $user
 */
class Domain extends Model
{
    protected $fillable = ['domain'];

    /**
     * Get the user that owns the domain.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
