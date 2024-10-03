<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Writer;

class WriterProfileController extends Controller
{
    // Show the writer profile page
    public function show()
    {
        $writer = Auth::guard('writer')->user();
        return view('profile.writer-profile', compact('writer'));
    }

    // Update the writer's profile
    public function update(Request $request)
    {
        // Validate input fields
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',
            'cropped_image_data' => 'nullable|string',  // Add this line
        ]);

        // Get the currently authenticated writer
        $writer = Auth::guard('writer')->user();

        // Ensure the authenticated user is an instance of Writer
        if (!$writer instanceof Writer) {
            return redirect()->back()->with('error', 'Invalid user type');
        }

        // Handle cropped image upload if provided
        if ($request->cropped_image_data) {
            try {
                // Decode base64 image data
                $imageData = $request->cropped_image_data;
                $imageData = str_replace('data:image/png;base64,', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);

                // Generate a unique name for the image
                $imageName = 'profile_images/' . uniqid() . '.png';

                // Store the image in the public disk
                if (Storage::disk('public')->put($imageName, base64_decode($imageData))) {
                    // Optionally delete the old profile image if it exists
                    if ($writer->profile_image) {
                        Storage::disk('public')->delete($writer->profile_image);
                    }

                    // Update writer's profile image path
                    $writer->profile_image = $imageName;
                    Log::info('Profile image saved successfully: ' . $imageName);
                } else {
                    Log::error('Failed to save image: ' . $imageName);
                }
            } catch (\Exception $e) {
                Log::error('Failed to process image: ' . $e->getMessage());
            }
        } elseif ($request->hasFile('profile_image')) { // Handle non-cropped image uploads
            // Delete old image if exists
            if ($writer->profile_image) {
                Storage::disk('public')->delete($writer->profile_image);
            }
            // Store the new image
            $filePath = $request->file('profile_image')->store('profile_images', 'public');
            $writer->profile_image = $filePath;
        }

        // Update other profile details
        $writer->name = $request->name;
        $writer->bio = $request->bio;
        $writer->skills = $request->skills;

        // Calculate profile completion percentage
        $completionFields = ['name', 'bio', 'skills', 'profile_image'];
        $filledFields = array_filter($completionFields, function ($field) use ($writer) {
            return !empty($writer->$field);
        });
        $writer->profile_completion = (count($filledFields) / count($completionFields)) * 100;

        // Save writer's profile and handle potential errors
        try {
            $writer->save();
            return redirect()->route('writer.profile')->with('status', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving writer profile: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while saving your profile. Please try again.');
        }
    }

    // Show the public profile of a writer
    public function viewPublic($id)
    {
        // Find the writer and load their ratings with employer data
        $writer = Writer::with('ratings.employer')->findOrFail($id);

        // Calculate the average rating for the writer
        $averageRating = $writer->ratings()->avg('rating');

        // Render the public profile view
        return view('profile.writer-profile-public', compact('writer', 'averageRating'));
    }
}
