<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
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

    // Handle withdrawal request
    public function requestWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $writer = Auth::user();

        // Check if the writer has sufficient balance
        if ($writer->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }

        // Create a new withdrawal record
        $withdrawal = new Withdrawal();
        $withdrawal->writer_id = $writer->id;
        $withdrawal->amount = $request->amount;
        $withdrawal->save(); // Save withdrawal record

        // No need to update balance directly, as it's calculated dynamically

        return redirect()->route('writer.balance')->with('success', 'Withdrawal request successful.');
    }

    // Update an existing withdrawal request
    public function updateWithdrawal(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Find the existing withdrawal record by its ID
        $withdrawal = Withdrawal::find($id);

        if ($withdrawal) {
            $withdrawal->amount = $request->amount; // Set new amount
            $withdrawal->save(); // Save the changes

            return redirect()->route('writer.balance')->with('success', 'Withdrawal updated successfully.');
        }

        return redirect()->route('writer.balance')->with('error', 'Withdrawal not found.');
    }
}
