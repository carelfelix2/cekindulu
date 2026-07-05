<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class MembershipActivated extends Notification
{
    use Queueable;

    public function __construct(public Transaction $transaction)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $planName = $this->transaction->membershipPlan?->name ?? 'Membership Premium';

        return [
            'type' => 'membership_activated',
            'title' => 'Membership aktif',
            'message' => "Pembayaran berhasil. {$planName} telah diaktifkan.",
            'transaction_id' => $this->transaction->id,
            'invoice_number' => $this->transaction->invoice_number,
        ];
    }
}
