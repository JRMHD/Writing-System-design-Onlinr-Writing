<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class WriterDashboardController extends Controller
{
    public function index()
    {
        $writer = Auth::guard('writer')->user();

        // Check if the writer is authenticated
        if (!$writer) {
            return redirect()->route('login')->with('error', 'You must be logged in to view the dashboard.');
        }

        $availableAssignments = Assignment::where('status', 'open')
            ->latest()
            ->get();

        $bids = Bid::where('writer_id', $writer->id)
            ->with('assignment')
            ->latest()
            ->get();

        // Return the view with necessary data
        return view('writer.dashboard', compact('writer', 'availableAssignments', 'bids'));
    }
}
