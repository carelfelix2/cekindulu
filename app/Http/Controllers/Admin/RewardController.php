<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    /**
     * Display a listing of pending reward points.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $rewards = RewardPoint::with(['user', 'approver'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        $stats = [
            'pending_count' => RewardPoint::where('status', 'pending')->count(),
            'pending_points' => RewardPoint::where('status', 'pending')->sum('points'),
            'approved_count' => RewardPoint::where('status', 'approved')->count(),
            'approved_points' => RewardPoint::where('status', 'approved')->sum('points'),
        ];

        return view('admin.rewards.index', compact('rewards', 'stats', 'status'));
    }

    /**
     * Approve a reward point.
     */
    public function approve(Request $request, RewardPoint $reward)
    {
        if ($reward->status !== 'pending') {
            return back()->with('error', 'Reward sudah diproses sebelumnya.');
        }

        $reward->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Reward berhasil disetujui!');
    }

    /**
     * Reject a reward point.
     */
    public function reject(Request $request, RewardPoint $reward)
    {
        if ($reward->status !== 'pending') {
            return back()->with('error', 'Reward sudah diproses sebelumnya.');
        }

        $reward->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'rejected_at' => now(),
            'notes' => $request->notes ?? 'Ditolak oleh admin',
        ]);

        return back()->with('success', 'Reward berhasil ditolak.');
    }

    /**
     * Bulk approve rewards.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'reward_ids' => 'required|array',
            'reward_ids.*' => 'exists:reward_points,id',
        ]);

        $count = RewardPoint::whereIn('id', $request->reward_ids)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

        return back()->with('success', "{$count} reward berhasil disetujui!");
    }
}
