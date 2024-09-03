<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    // Show Employer Dashboard
    public function index()
    {
        $employer = Auth::guard('employer')->user();
        $assignments = Assignment::where('employer_id', $employer->id)->get();
        return view('employer.dashboard', compact('assignments'));
    }

    // Show Form to Create Assignment
    public function createAssignment()
    {
        return view('employer.create-assignment');
    }

    // Store New Assignment
    public function storeAssignment(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'word_count' => 'required|integer',
            'budget' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $employer = Auth::guard('employer')->user();

        Assignment::create([
            'employer_id' => $employer->id,
            'title' => $request->title,
            'description' => $request->description,
            'word_count' => $request->word_count,
            'budget' => $request->budget,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('employer.dashboard')->with('success', 'Assignment created successfully.');
    }

    // Show Assignment Details and Bids
    public function showAssignment(Assignment $assignment)
    {
        $this->authorize('view', $assignment); // Ensure the employer owns the assignment
        $bids = $assignment->bids()->with('writer')->get();
        return view('employer.show-assignment', compact('assignment', 'bids'));
    }
}
