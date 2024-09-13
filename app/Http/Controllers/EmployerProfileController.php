<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Employer;

class EmployerProfileController extends Controller
{
    public function show()
    {
        $employer = Auth::guard('employer')->user();
        return view('profile.employer-profile', compact('employer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',

        ]);

        $employer = Auth::guard('employer')->user();

        if (!$employer instanceof Employer) {
            Log::error('Invalid user type in EmployerProfileController');
            return redirect()->back()->with('error', 'Invalid user type');
        }

        if ($request->hasFile('profile_image')) {
            if ($employer->profile_image) {
                Storage::disk('public')->delete($employer->profile_image);
            }
            $filePath = $request->file('profile_image')->store('profile_images', 'public');
            $employer->profile_image = $filePath;
        }

        $employer->name = $request->name;
        $employer->bio = $request->bio;

        $employer->profile_completion = 100; // Adjust based on completion criteria

        try {
            Log::info('Employer object before save: ' . json_encode($employer->toArray()));
            $result = $employer->save();
            Log::info('Save result: ' . ($result ? 'true' : 'false'));

            if ($result) {
                return redirect()->route('employer.profile')->with('status', 'Profile updated successfully!');
            } else {
                Log::error('Failed to save employer profile');
                return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Error saving employer profile: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while saving your profile. Please try again.');
        }
    }
}
