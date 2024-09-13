<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Writer;

class WriterProfileController extends Controller
{
    public function show()
    {
        $writer = Auth::guard('writer')->user();
        return view('profile.writer-profile', compact('writer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',

        ]);

        $writer = Auth::guard('writer')->user();

        if (!$writer instanceof Writer) {
            return redirect()->back()->with('error', 'Invalid user type');
        }

        if ($request->hasFile('profile_image')) {
            if ($writer->profile_image) {
                Storage::disk('public')->delete($writer->profile_image);
            }
            $filePath = $request->file('profile_image')->store('profile_images', 'public');
            $writer->profile_image = $filePath;
        }

        $writer->name = $request->name;
        $writer->bio = $request->bio;
        $writer->skills = $request->skills;

        $writer->profile_completion = 100; // Adjust based on completion criteria

        try {
            Log::info('Writer object before save: ' . json_encode($writer->toArray()));
            $result = $writer->save();
            Log::info('Save result: ' . ($result ? 'true' : 'false'));
            return redirect()->route('writer.profile')->with('status', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving writer profile: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while saving your profile. Please try again.');
        }
    }
}
