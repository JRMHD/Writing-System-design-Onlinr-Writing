<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\Payment;
use App\Models\Writer;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employer');
    }

    public function index()
    {
        $assignments = Assignment::where('employer_id', Auth::id())
            ->orderBy('created_at', 'desc')  // Changed to 'desc' to show latest on top
            ->get();

        return view('employer.assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('employer.assignments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'word_count' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'budget' => 'required|numeric|min:0.01',
        ]);

        Assignment::create([
            'employer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'word_count' => $request->word_count,
            'deadline' => $request->deadline,
            'budget' => $request->budget,
        ]);

        return redirect()->route('employer.assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function show($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        return view('employer.assignments.show', compact('assignment'));
    }

    public function edit($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        return view('employer.assignments.edit', compact('assignment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'word_count' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'budget' => 'required|numeric|min:0.01',
        ]);

        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        $assignment->update($request->only(['title', 'description', 'word_count', 'deadline', 'budget']));

        return redirect()->route('employer.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    public function destroy($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        $assignment->delete();

        return redirect()->route('employer.assignments.index')->with('success', 'Assignment deleted successfully.');
    }

    public function bidOnAssignments()
    {
        $assignments = Assignment::where('employer_id', Auth::id())
            ->whereHas('bids')
            ->with('bids')  // Eager load bids
            ->orderBy('created_at', 'desc')  // Changed to 'desc' to show latest on top
            ->get();

        return view('employer.assignments.bid_on', compact('assignments'));
    }

    public function givenOutAssignments()
    {
        // Fetch ongoing assignments
        $assignments = Assignment::where('employer_id', Auth::id())
            ->whereHas('bids', function ($query) {
                $query->where('status', 'accepted')->whereHas('writer');
            })
            ->where('completed', false)  // Fetch only ongoing assignments
            ->with(['acceptedBid.writer'])
            ->orderBy('created_at', 'desc')  // Changed to 'desc' to show latest on top
            ->get();

        // Fetch completed assignments
        $completedAssignments = Assignment::where('employer_id', Auth::id())
            ->whereHas('bids', function ($query) {
                $query->where('status', 'accepted')->whereHas('writer');
            })
            ->where('completed', true)  // Fetch only completed assignments
            ->with(['acceptedBid.writer'])
            ->orderBy('created_at', 'desc')  // Changed to 'desc' to show latest on top
            ->get();

        return view('employer.assignments.given_out', compact('assignments', 'completedAssignments'));
    }

    // In markAsCompleted method:
    public function markAsCompleted($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        $assignment->completed = true;

        // Get the accepted bid and writer
        $bid = $assignment->bids()->where('status', 'accepted')->first();
        if ($bid) {
            $writer = $bid->writer;
            $amount = $bid->amount;

            // Deduct from employer wallet
            $wallet = Wallet::where('employer_id', Auth::id())->first();
            if ($wallet->balance >= $amount) {
                $wallet->balance -= $amount;
                $wallet->save();

                // Record payment to writer
                Payment::create([
                    'writer_id' => $writer->id,
                    'assignment_id' => $assignment->id,
                    'amount' => $amount,
                ]);

                $assignment->save();
                return redirect()->route('employer.assignments.given-out')->with('success', 'Assignment marked as completed and payment processed.');
            } else {
                return redirect()->route('employer.assignments.given-out')->withErrors(['error' => 'Insufficient wallet balance.']);
            }
        }

        return redirect()->route('employer.assignments.given-out')->withErrors(['error' => 'No accepted bid for this assignment.']);
    }
}
