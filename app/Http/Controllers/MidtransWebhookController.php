<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UserMembership;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Handle Midtrans notification webhook.
     */
    public function notification(Request $request)
    {
        try {
            $payload = $request->all();
            Log::info('Midtrans Webhook Received', $payload);

            // Extract data from payload
            $orderId = $payload['order_id'] ?? null;
            $statusCode = $payload['status_code'] ?? null;
            $grossAmount = $payload['gross_amount'] ?? null;
            $signatureKey = $payload['signature_key'] ?? null;
            $transactionStatus = $payload['transaction_status'] ?? null;
            $fraudStatus = $payload['fraud_status'] ?? null;
            $paymentType = $payload['payment_type'] ?? null;

            // Verify signature
            if (!$this->midtrans->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
                Log::error('Midtrans Invalid Signature', $payload);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Find transaction
            $transaction = Transaction::where('invoice_number', $orderId)->first();

            if (!$transaction) {
                Log::error('Midtrans Transaction Not Found', ['order_id' => $orderId]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Store raw payload
            $transaction->update(['raw_payload' => json_encode($payload)]);

            // Handle transaction status
            DB::beginTransaction();
            try {
                if ($transactionStatus === 'capture') {
                    if ($fraudStatus === 'accept') {
                        $this->handleSuccess($transaction, $payload);
                    }
                } elseif ($transactionStatus === 'settlement') {
                    $this->handleSuccess($transaction, $payload);
                } elseif ($transactionStatus === 'pending') {
                    $transaction->update([
                        'status' => 'pending',
                        'payment_reference' => $payload['transaction_id'] ?? null,
                    ]);
                } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $transaction->update([
                        'status' => $transactionStatus === 'deny' ? 'failed' : $transactionStatus,
                        'payment_reference' => $payload['transaction_id'] ?? null,
                    ]);
                }

                DB::commit();
                Log::info('Midtrans Webhook Processed Successfully', [
                    'order_id' => $orderId,
                    'status' => $transactionStatus,
                ]);

                return response()->json(['message' => 'OK']);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    /**
     * Handle successful payment.
     */
    protected function handleSuccess(Transaction $transaction, array $payload): void
    {
        // Update transaction
        $transaction->update([
            'status' => 'paid',
            'payment_reference' => $payload['transaction_id'] ?? null,
            'paid_at' => now(),
        ]);

        // Activate or extend membership
        $this->activateMembership($transaction);
    }

    /**
     * Activate or extend user membership.
     */
    protected function activateMembership(Transaction $transaction): void
    {
        $user = $transaction->user;
        $plan = $transaction->membershipPlan;

        // Check if user has active membership
        $activeMembership = $user->userMemberships()
            ->where('is_active', true)
            ->where('ends_at', '>=', now())
            ->first();

        if ($activeMembership) {
            // Extend existing membership
            $newEndsAt = \Carbon\Carbon::parse($activeMembership->ends_at)
                ->addDays($plan->duration_days);

            $activeMembership->update(['ends_at' => $newEndsAt]);

            Log::info('Membership Extended', [
                'user_id' => $user->id,
                'new_ends_at' => $newEndsAt,
            ]);
        } else {
            // Create new membership
            $startsAt = now();
            $endsAt = now()->addDays($plan->duration_days);

            UserMembership::create([
                'user_id' => $user->id,
                'membership_plan_id' => $plan->id,
                'transaction_id' => $transaction->id,
                'started_at' => $startsAt,
                'ends_at' => $endsAt,
                'is_active' => true,
            ]);

            Log::info('Membership Activated', [
                'user_id' => $user->id,
                'ends_at' => $endsAt,
            ]);
        }
    }
}
