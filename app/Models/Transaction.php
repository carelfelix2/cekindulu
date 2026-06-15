<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'invoice_number',
        'amount',
        'payment_method',
        'status',
        'payment_proof',
        'admin_notes',
        'paid_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'paid_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function membershipPlan(): BelongsTo
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function userMembership()
    {
        return $this->hasOne(UserMembership::class);
    }

    /**
     * Format amount to Rupiah.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'badge-success',
            'pending' => 'badge-warning',
            'failed' => 'badge-danger',
            'expired' => 'badge-secondary',
            'cancelled' => 'badge-secondary',
            default => 'badge-secondary',
        };
    }

    /**
     * Generate a unique invoice number.
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-CDL-';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));

        return $prefix . $date . '-' . $random;
    }
}
