<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:writer');
    }

    // Show writer balance and history
    public function showBalance()
    {
        $writer = Auth::user();
        $payments = $writer->payments;
        $withdrawals = $writer->withdrawals;

        return view('writer.balance', compact('writer', 'payments', 'withdrawals'));
    }

    /**
     * Handle withdrawal request via AJAX
     */
    public function requestWithdrawal(Request $request)
    {
        // Validate the withdrawal amount
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $writer = Auth::user();
        $amount = $request->amount;

        // Check if the writer has sufficient balance
        if ($writer->balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance for this withdrawal.',
            ], 400);
        }

        // Create a new withdrawal record with status 'pending'
        $withdrawal = Withdrawal::create([
            'writer_id' => $writer->id,
            'amount' => $amount,
            'status' => 'pending', // Assuming you have a status field
        ]);

        // Update the writer's balance
        Writer::where('id', $writer->id)->decrement('balance', $amount);

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal request successful. It will be processed shortly.',
        ]);
    }
}
