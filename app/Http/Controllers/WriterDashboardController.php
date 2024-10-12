<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Bid;
use App\Models\Subscription; // Import Subscription model
use App\Models\Writer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WriterDashboardController extends Controller
{
    public function index()
    {
        // Retrieve authenticated writer
        $writer = Auth::guard('writer')->user();

        // Check if the writer is authenticated
        if (!$writer) {
            return redirect()->route('login')->with('error', 'You must be logged in to view the dashboard.');
        }

        // Fetch available assignments with eager loading
        $availableAssignments = Assignment::where('status', 'open')->latest()->get();

        // Fetch all bids for the authenticated writer
        $bids = Bid::where('writer_id', $writer->id)->latest()->get();

        // Fetch active bids count
        $activeBidsCount = Bid::where('writer_id', $writer->id)
            ->where('status', 'accepted')
            ->whereHas('assignment', function ($query) {
                $query->where('completed', false);
            })
            ->count();

        // Fetch completed bids count
        $completedBidsCount = Bid::where('writer_id', $writer->id)
            ->whereHas('assignment', function ($query) {
                $query->where('completed', true);
            })
            ->count();

        // Fetch payments and withdrawals, sorted by creation date
        $payments = $writer->payments->sortByDesc('created_at');
        $withdrawals = $writer->withdrawals->sortByDesc('created_at');


        // Fetch active subscriptions for the writer
        $subscriptions = $writer->subscriptions; // This line retrieves subscriptions

        return view('writer.dashboard', compact(
            'writer',
            'availableAssignments',
            'bids',
            'payments',
            'withdrawals',
            'activeBidsCount',
            'completedBidsCount',
            'subscriptions' // Pass subscriptions to the view
        ));
    }
}
