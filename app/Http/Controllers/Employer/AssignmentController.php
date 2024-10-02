<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Wallet;
use App\Models\Payment;
use App\Models\Writer;

class AssignmentController extends Controller
{
    public function __construct()
    {
        // Ensures only authenticated employers can access these routes
        $this->middleware('auth:employer');
    }

    // Display the list of assignments for the authenticated employer
    public function index()
    {
        $assignments = Assignment::where('employer_id', Auth::id())
            ->orderBy('created_at', 'desc')  // Latest assignments first
            ->get();

        return view('employer.assignments.index', compact('assignments'));
    }

    // Show the form to create a new assignment
    public function create()
    {
        return view('employer.assignments.create');
    }

    // Store a new assignment in the database
    public function store(Request $request)
    {
        // Validate input including file upload
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'word_count' => 'required|integer|min:1',
            'deadline' => 'required|date|after:today',
            'budget' => 'required|numeric|min:0.01',
            'language' => 'required|string',
            'academic_level' => 'required|string',
            'topic' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048' // Validate the file
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments_files', 'public');
        }

        // Create the assignment with the validated data
        Assignment::create([
            'employer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'word_count' => $request->word_count,
            'deadline' => $request->deadline,
            'budget' => $request->budget,
            'language' => $request->language,
            'academic_level' => $request->academic_level,
            'topic' => $request->topic,
            'file' => $filePath, // Save file path if uploaded
        ]);

        return redirect()->route('employer.assignments.index')->with('success', 'Assignment created successfully.');
    }

    // Show details of a single assignment
    public function show($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        return view('employer.assignments.show', compact('assignment'));
    }

    // Show the form to edit an existing assignment
    public function edit($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        return view('employer.assignments.edit', compact('assignment'));
    }

    // Update an existing assignment in the database
    public function update(Request $request, $id)
    {
        // Validate the updated data, including file upload
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'word_count' => 'required|integer|min:1',
            'deadline' => 'required|date|after:today',
            'budget' => 'required|numeric|min:0.01',
            'language' => 'required|string',
            'academic_level' => 'required|string',
            'topic' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048' // Validate file
        ]);

        // Handle file upload if there's a new file
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($assignment->file) {
                Storage::disk('public')->delete($assignment->file);
            }
            $assignment->file = $request->file('file')->store('assignments_files', 'public');
        }

        // Update assignment with the new data
        $assignment->update($request->only([
            'title',
            'description',
            'word_count',
            'deadline',
            'budget',
            'language',
            'academic_level',
            'topic'
        ]));

        $assignment->save();

        return redirect()->route('employer.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    // Delete an assignment
    public function destroy($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        if ($assignment->file) {
            Storage::disk('public')->delete($assignment->file); // Remove file if it exists
        }
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
