<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        return view('pages.membership.checkout', compact('plan'));
    }

    /**
     * Process the checkout / submit transaction with payment proof.
     */
    public function processCheckout(Request $request, string $slug)
    {
        $plan = MembershipPlan::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'payment_method' => ['required', 'string', 'max:50'],
        ]);

        $user = Auth::user();

        // Upload payment proof
        $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Create transaction
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'invoice_number' => Transaction::generateInvoiceNumber(),
            'amount' => $plan->price,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_proof' => $paymentProofPath,
            'expires_at' => now()->addDays(2), // auto-expire if not paid in 2 days
        ]);

        return redirect()
            ->route('membership.transactions.detail', $transaction->invoice_number)
            ->with('success', 'Pembayaran berhasil dikirim! Silakan tunggu konfirmasi dari admin.');
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
