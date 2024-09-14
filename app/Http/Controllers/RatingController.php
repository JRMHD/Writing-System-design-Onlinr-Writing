<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Writer;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employer');
    }

    public function create($writerId)
    {
        $writer = Writer::findOrFail($writerId);
        return view('ratings.create', compact('writer'));
    }

    public function store(Request $request, $writerId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'remarks' => 'nullable|string',
        ]);

        $employer = Auth::guard('employer')->user();

        if (!$employer) {
            return redirect()->route('employer.login')->with('error', 'You must be logged in as an employer to submit a rating.');
        }

        $rating = Rating::where('writer_id', $writerId)
            ->where('employer_id', $employer->id)
            ->first();

        if ($rating) {
            // Update existing rating
            $rating->rating = $request->rating;
            $rating->remarks = $request->remarks;
            $rating->save();
            $message = 'Rating updated successfully!';
        } else {
            // Create new rating
            $rating = new Rating([
                'writer_id' => $writerId,
                'employer_id' => $employer->id,
                'rating' => $request->rating,
                'remarks' => $request->remarks,
            ]);
            $rating->save();
            $message = 'Rating submitted successfully!';
        }

        return redirect()->route('writer.profile.public', $writerId)->with('status', $message);
    }
}
