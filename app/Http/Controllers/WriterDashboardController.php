<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class WriterDashboardController extends Controller
{
    public function index()
    {
        // Fetch all bids for the authenticated writer
        $bids = Bid::where('writer_id', Auth::id())->get();

        return view('writer.dashboard', compact('bids'));
    }
}
