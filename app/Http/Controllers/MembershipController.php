<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    /**
     * Display a listing of available membership plans.
     */
    public function index()
    {
        $plans = MembershipPlan::where('is_active', true)->get();

        return view('pages.membership.index', compact('plans'));
    }

    /**
     * Show the checkout page for a specific plan.
     */
    public function checkout(string $slug)
    {
        $plan = MembershipPlan::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $user = Auth::user();

        // Check if user has pending transaction for this plan
        $pendingTransaction = Transaction::where('user_id', $user->id)
            ->where('membership_plan_id', $plan->id)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->first();

        if ($pendingTransaction) {
            return redirect()
                ->route('membership.transactions.detail', $pendingTransaction->invoice_number)
                ->with('info', 'Anda masih memiliki transaksi pending untuk paket ini.');
        }

        return view('pages.membership.checkout', compact('plan'));
    }

    /**
     * Process the checkout - Create transaction for simulation.
     */
    public function processCheckout(Request $request, string $slug)
    {
        $plan = MembershipPlan::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $user = Auth::user();

        // Create transaction with pending status
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'invoice_number' => Transaction::generateInvoiceNumber(),
            'amount' => $plan->price,
            'payment_method' => 'Simulation',
            'payment_gateway' => 'simulation',
            'status' => 'pending',
            'expires_at' => now()->addDays(2),
        ]);

        return redirect()
            ->route('membership.transactions.detail', $transaction->invoice_number)
            ->with('success', 'Transaksi berhasil dibuat! Silakan simulasikan pembayaran.');
    }

    /**
     * Simulate payment success.
     */
    public function simulatePaymentSuccess(string $invoiceNumber)
    {
        $transaction = Transaction::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        DB::transaction(function () use ($transaction) {
            // Generate simulation reference
            $paymentReference = 'SIM-' . strtoupper(substr(uniqid(), -8));

            // Update transaction
            $transaction->update([
                'status' => 'paid',
                'payment_method' => 'Simulation',
                'payment_reference' => $paymentReference,
                'paid_at' => now(),
            ]);

            // Create or update user membership
            $user = $transaction->user;
            $plan = $transaction->membershipPlan;

            $existingMembership = UserMembership::where('user_id', $user->id)->first();

            if ($existingMembership) {
                // Extend existing membership
                $newEndsAt = $existingMembership->ends_at && $existingMembership->ends_at->isFuture()
                    ? $existingMembership->ends_at->addDays($plan->duration_days)
                    : now()->addDays($plan->duration_days);

                $existingMembership->update([
                    'membership_plan_id' => $plan->id,
                    'transaction_id' => $transaction->id,
                    'started_at' => now(),
                    'ends_at' => $newEndsAt,
                    'is_active' => true,
                ]);
            } else {
                // Create new membership
                UserMembership::create([
                    'user_id' => $user->id,
                    'membership_plan_id' => $plan->id,
                    'transaction_id' => $transaction->id,
                    'started_at' => now(),
                    'ends_at' => now()->addDays($plan->duration_days),
                    'is_active' => true,
                ]);
            }

            // Create notification (if notification system exists)
            if (method_exists($user, 'notify')) {
                $user->notify(new \App\Notifications\MembershipActivated($transaction));
            }
        });

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Pembayaran berhasil disimulasikan. Membership Premium aktif.');
    }

    /**
     * Simulate payment failure.
     */
    public function simulatePaymentFailed(string $invoiceNumber)
    {
        $transaction = Transaction::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $transaction->update([
            'status' => 'failed',
            'payment_method' => 'Simulation',
        ]);

        return redirect()
            ->route('membership.transactions.detail', $transaction->invoice_number)
            ->with('error', 'Pembayaran gagal.');
    }

    /**
     * Keep transaction as pending (simulate pending state).
     */
    public function simulatePaymentPending(string $invoiceNumber)
    {
        $transaction = Transaction::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Just redirect back with info message
        return redirect()
            ->route('membership.transactions.detail', $transaction->invoice_number)
            ->with('info', 'Transaksi masih dalam status menunggu pembayaran.');
    }

    /**
     * Display user's transaction history.
     */
    public function transactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('membershipPlan')
            ->latest()
            ->paginate(10);

        return view('pages.membership.transactions', compact('transactions'));
    }

    /**
     * Display a single transaction detail.
     */
    public function transactionDetail(string $invoiceNumber)
    {
        $transaction = Transaction::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->with(['membershipPlan', 'userMembership'])
            ->firstOrFail();

        return view('pages.membership.transaction-detail', compact('transaction'));
    }
}
