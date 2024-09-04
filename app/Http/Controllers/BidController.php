<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    // Display all bids for a writer
    public function writerIndex()
    {
        $bids = Bid::where('writer_id', Auth::id())->get();
        return view('writer.bids.index', compact('bids'));
    }

    // Show form to create a new bid
    public function create()
    {
        $assignments = Assignment::all(); // Fetch all assignments for the form
        return view('writer.bids.create', compact('assignments'));
    }

    // Store a new bid
    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'amount' => 'required|numeric|min:0',
        ]);

        Bid::create([
            'assignment_id' => $request->assignment_id,
            'writer_id' => Auth::id(),
            'amount' => $request->amount,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('writer.bids.index')->with('success', 'Bid placed successfully.');
    }

    // Display all bids for an employer
    public function index($assignmentId)
    {
        $bids = Bid::where('assignment_id', $assignmentId)->get();
        return view('employer.assignments.bids.index', compact('bids'));
    }

    // Select a writer for an assignment
    public function selectWriter(Request $request)
    {
        $request->validate([
            'bid_id' => 'required|exists:bids,id',
        ]);

        $bid = Bid::findOrFail($request->bid_id);
        $bid->status = 'selected';
        $bid->save();

        return redirect()->route('employer.assignments.bids.index', ['assignmentId' => $bid->assignment_id])
            ->with('success', 'Writer selected successfully.');
    }
}
