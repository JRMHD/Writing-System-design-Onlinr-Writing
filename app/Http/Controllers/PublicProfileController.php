<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Writer;
use App\Models\Employer;

class PublicProfileController extends Controller
{
    public function showWriter($id)
    {
        $writer = Writer::findOrFail($id);

        if (!$writer->is_public) {
            abort(404); // Profile not found or not public
        }

        return view('profile.public-writer', compact('writer'));
    }

    public function showEmployer($id)
    {
        $employer = Employer::findOrFail($id);

        if (!$employer->is_public) {
            abort(404); // Profile not found or not public
        }

        return view('profile.public-employer', compact('employer'));
    }
}
