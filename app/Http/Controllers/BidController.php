<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Import Mail facade
use App\Mail\BidAcceptedNotification; // Import the mailable class

class BidController extends Controller
{
    /**
     * Display all bids for a writer.
     */
    public function writerIndex()
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        return view('writer.bids.index', ['bids' => Bid::where('writer_id', $writer->id)->latest()->get()]);
    }

    /**
     * Display all active (accepted) bids for a writer.
     */
    public function activeBids()
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        $activeBids = Bid::where('writer_id', $writer->id)
            ->where('status', 'accepted')
            ->whereHas('assignment', function ($query) {
                $query->where('completed', false);
            })
            ->orderBy('created_at', 'desc')  //latest
            ->get();

        $completedBids = Bid::where('writer_id', $writer->id)
            ->whereHas('assignment', function ($query) {
                $query->where('completed', true);
            })
            ->orderBy('created_at', 'desc')  // latest
            ->get();

        return view('writer.bids.active', [
            'activeBids' => $activeBids,
            'completedBids' => $completedBids
        ]);
    }

    /**
     * Display other views information (rejected, in-progress, completed).
     */
    public function otherViews()
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        $bids = Bid::where('writer_id', $writer->id)
            ->whereIn('status', ['rejected', 'in-progress', 'completed'])
            ->latest()
            ->limit(5)
            ->get();

        return view('writer.bids.other_views', ['bids' => $bids]);
    }

    /**
     * List all available assignments for writers.
     */
    public function listAvailableAssignments()
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        $assignments = Assignment::where('status', 'open')->latest()->get();
        return view('writer.assignments.index', ['assignments' => $assignments]);
    }

    /**
     * Show assignment details.
     */
    public function showAssignmentDetails($id)
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        return view('writer.assignments.show', ['assignment' => Assignment::findOrFail($id)]);
    }

    /**
     * Show form to create a new bid.
     */
    public function create($assignmentId)
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        return view('writer.bids.create', ['assignment' => Assignment::findOrFail($assignmentId)]);
    }

    /**
     * Store a new bid.
     */
    public function store(Request $request)
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'amount' => 'required|numeric|min:0',
            'message' => 'nullable|string|max:255',
        ]);

        Bid::create([
            'assignment_id' => $request->assignment_id,
            'writer_id' => $writer->id,
            'amount' => $request->amount,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('writer.bids.index')->with('success', 'Bid placed successfully.');
    }

    /**
     * Display all bids for an employer.
     */
    public function index($assignmentId)
    {
        return view('employer.assignments.bids.index', [
            'bids' => Bid::where('assignment_id', $assignmentId)->latest()->get(),
            'assignment' => Assignment::findOrFail($assignmentId),
        ]);
    }

    /**
     * Select a writer for an assignment.
     */
    public function selectWriter(Request $request)
    {
        $request->validate(['bid_id' => 'required|exists:bids,id']);
        $bid = Bid::findOrFail($request->bid_id);
        $bid->status = 'selected';
        $bid->save();

        return redirect()->route('employer.assignments.bids.index', ['assignmentId' => $bid->assignment_id])
            ->with('success', 'Writer selected successfully.');
    }

    /**
     * Update the status of a bid.
     */
    public function updateStatus($id, $status)
    {
        $validStatuses = ['accepted', 'rejected', 'in-progress', 'completed'];
        if (!in_array($status, $validStatuses)) return back()->withErrors(['error' => 'Invalid status.']);

        $bid = Bid::findOrFail($id);
        $bid->status = $status;
        $bid->save();

        // Send email if the bid is accepted
        if ($status === 'accepted') {
            $writer = $bid->writer;
            Mail::to($writer->email)->send(new BidAcceptedNotification($writer, $bid));
        }

        return redirect()->back()->with('success', 'Bid status updated successfully.');
    }

    /**
     * Cancel a bid.
     */
    public function cancelBid($id)
    {
        $writer = Auth::guard('writer')->user();
        if (!$writer) return redirect()->route('writer.login')->withErrors(['error' => 'You must be logged in as a writer.']);

        $bid = Bid::where('writer_id', $writer->id)->findOrFail($id);
        $bid->status = 'cancelled';
        $bid->save();

        return redirect()->route('writer.bids.active')->with('success', 'Bid cancelled successfully.');
    }
}
