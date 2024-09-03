<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WriterDashboardController extends Controller
{
    // Show Writer Dashboard
    public function index()
    {
        $assignments = Assignment::where('status', 'open')->get();
        return view('writer.dashboard', compact('assignments'));
    }

    // Show Assignment Details
    public function showAssignment(Assignment $assignment)
    {
        return view('writer.show-assignment', compact('assignment'));
    }

    // Store Bid
    public function storeBid(Request $request, Assignment $assignment)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'proposal' => 'required|string',
        ]);

        $writer = Auth::guard('writer')->user();

        Bid::create([
            'assignment_id' => $assignment->id,
            'writer_id' => $writer->id,
            'amount' => $request->amount,
            'proposal' => $request->proposal,
        ]);

        return redirect()->route('writer.dashboard')->with('success', 'Bid submitted successfully.');
    }
}
