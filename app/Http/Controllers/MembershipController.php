<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\UserMembership;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

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
     * Process the checkout - Create transaction and Midtrans Snap token.
     */
    public function processCheckout(Request $request, string $slug)
    {
        $plan = MembershipPlan::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $request->validate([
            'payment_method' => ['required', 'string', 'in:midtrans,manual_transfer'],
        ]);

        $user = Auth::user();
        $paymentMethod = $request->payment_method;

        // Create transaction
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'invoice_number' => Transaction::generateInvoiceNumber(),
            'amount' => $plan->price,
            'payment_method' => $paymentMethod,
            'payment_gateway' => $paymentMethod === 'midtrans' ? 'midtrans' : 'manual_transfer',
            'status' => 'pending',
            'expires_at' => now()->addDays(2),
        ]);

        // If Midtrans, create Snap token
        if ($paymentMethod === 'midtrans') {
            $snapResult = $this->midtrans->createSnapToken($transaction);

            if ($snapResult['success']) {
                $transaction->update([
                    'snap_token' => $snapResult['snap_token'],
                    'snap_redirect_url' => $snapResult['redirect_url'],
                ]);

                return redirect()
                    ->route('membership.transactions.detail', $transaction->invoice_number)
                    ->with('success', 'Transaksi berhasil dibuat! Silakan lanjutkan pembayaran.');
            } else {
                $transaction->update(['status' => 'failed']);
                return back()->with('error', 'Gagal membuat token pembayaran: ' . ($snapResult['message'] ?? 'Unknown error'));
            }
        }

        // Manual transfer - require payment proof upload
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            $transaction->update(['payment_proof' => $paymentProofPath]);
        }

        return redirect()
            ->route('membership.transactions.detail', $transaction->invoice_number)
            ->with('success', 'Transaksi berhasil dibuat! Silakan upload bukti pembayaran.');
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

        $midtransClientKey = config('services.midtrans.client_key');

        return view('pages.membership.transaction-detail', compact('transaction', 'midtransClientKey'));
    }

    /**
     * Upload payment proof for manual transfer.
     */
    public function uploadPaymentProof(Request $request, string $invoiceNumber)
    {
        $transaction = Transaction::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Delete old payment proof if exists
        if ($transaction->payment_proof) {
            Storage::disk('public')->delete($transaction->payment_proof);
        }

        // Upload new payment proof
        $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        $transaction->update(['payment_proof' => $paymentProofPath]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}
