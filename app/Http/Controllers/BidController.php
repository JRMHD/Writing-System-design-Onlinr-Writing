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
        // Ensure the authenticated user is a writer
        $writer = Auth::guard('writer')->user();
        if (!$writer) {
            return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer to view bids.']);
        }

        $bids = Bid::where('writer_id', $writer->id)->get();
        return view('writer.bids.index', compact('bids'));
    }

    // Show form to create a new bid
    public function create()
    {
        // Ensure the authenticated user is a writer
        $writer = Auth::guard('writer')->user();
        if (!$writer) {
            return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer to create a bid.']);
        }

        $assignments = Assignment::all(); // Fetch all assignments for the form
        return view('writer.bids.create', compact('assignments'));
    }

    // Store a new bid
    public function store(Request $request)
    {
        // Ensure the authenticated user is a writer
        $writer = Auth::guard('writer')->user();
        if (!$writer) {
            return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer to place a bid.']);
        }

        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'amount' => 'required|numeric|min:0',
            'message' => 'nullable|string|max:255',
        ]);

        // Insert the bid with the authenticated writer's ID
        Bid::create([
            'assignment_id' => $request->assignment_id,
            'writer_id' => $writer->id, // Use the authenticated writer's ID
            'amount' => $request->amount,
            'message' => $request->message,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('writer.bids.index')->with('success', 'Bid placed successfully.');
    }


    // Display all bids for an employer
    public function index($assignmentId)
    {
        // Fetch the assignment
        $assignment = Assignment::findOrFail($assignmentId);

        // Fetch all bids related to this assignment
        $bids = Bid::where('assignment_id', $assignmentId)->get();

        // Pass both the assignment and bids to the view
        return view('employer.assignments.bids.index', compact('bids', 'assignment'));
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
