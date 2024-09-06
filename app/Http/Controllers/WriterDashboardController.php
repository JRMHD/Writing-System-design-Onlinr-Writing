<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class WriterDashboardController extends Controller
{
    public function index()
    {
        $writer = Auth::guard('writer')->user();

        $availableAssignments = Assignment::where('status', 'open')->get();
        $bids = Bid::where('writer_id', $writer->id)->with('assignment')->get();

        return view('writer.dashboard', compact('availableAssignments', 'bids'));
    }
}
