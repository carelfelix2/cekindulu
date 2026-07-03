<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardPoint extends Model
{
    protected $fillable = [
        'user_id',
        'source_type',
        'source_id',
        'points',
        'status',
        'approved_by',
        'approved_at',
        'rejected_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the reward point.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who approved/rejected the reward.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the source model (polymorphic-like, but simplified).
     */
    public function source()
    {
        if ($this->source_type === 'affiliate_click') {
            return AffiliateClick::find($this->source_id);
        }
        return null;
    }

    /**
     * Scope to get only pending points.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get only approved points.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get only rejected points.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
