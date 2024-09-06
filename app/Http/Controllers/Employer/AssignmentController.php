<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the assignments.
     */
    public function index()
    {
        // Get the assignments ordered by the most recent first
        $assignments = Assignment::where('employer_id', Auth::id())
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->get();

        return view('employer.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create()
    {
        return view('employer.assignments.create');
    }

    /**
     * Store a newly created assignment in storage.
     */
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

    /**
     * Show the form for editing the specified assignment.
     */
    public function edit($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        return view('employer.assignments.edit', compact('assignment'));
    }

    /**
     * Update the specified assignment in storage.
     */
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

    /**
     * Remove the specified assignment from storage.
     */
    public function destroy($id)
    {
        $assignment = Assignment::where('employer_id', Auth::id())->findOrFail($id);
        $assignment->delete();

        return redirect()->route('employer.assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}
