<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Bid;
use App\Models\Wallet;
use App\Models\EmployerSubscription; // Add this line
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employer');
    }

    public function index()
    {
        $employer = Auth::user();

        // Get total assignments
        $totalAssignments = Assignment::where('employer_id', $employer->id)->count();

        // Get open assignments
        $openAssignments = Assignment::where('employer_id', $employer->id)
            ->where('status', 'open')
            ->count();

        // Get ongoing assignments
        $ongoingAssignments = Assignment::where('employer_id', $employer->id)
            ->whereHas('bids', function ($query) {
                $query->where('status', 'accepted');
            })
            ->where('completed', false)
            ->count();

        // Get completed assignments
        $completedAssignments = Assignment::where('employer_id', $employer->id)
            ->where('completed', true)
            ->count();

        // Get total bids received
        $totalBids = Bid::whereHas('assignment', function ($query) use ($employer) {
            $query->where('employer_id', $employer->id);
        })->count();

        // Get wallet balance
        $wallet = Wallet::where('employer_id', $employer->id)->first();
        $walletBalance = $wallet ? $wallet->balance : 0;

        // Get recent assignments
        $recentAssignments = Assignment::where('employer_id', $employer->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get active subscription
        $activeSubscription = EmployerSubscription::where('employer_id', $employer->id)
            ->where('end_date', '>', now()) // Ensure subscription is still active
            ->first();

        return view('employer.assignments.dashboard', compact(
            'totalAssignments',
            'openAssignments',
            'ongoingAssignments',
            'completedAssignments',
            'totalBids',
            'walletBalance',
            'recentAssignments',
            'activeSubscription' // Add this line
        ));
    }
}
