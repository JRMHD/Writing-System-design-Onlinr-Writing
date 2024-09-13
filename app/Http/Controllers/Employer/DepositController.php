<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    // Handle deposit
    public function store(Request $request)
    {
        // Validate the deposit amount
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Retrieve or create the wallet for the authenticated employer
        $wallet = Wallet::firstOrCreate(['employer_id' => Auth::id()]);

        // Update wallet balance
        $wallet->balance += $request->amount;
        $wallet->save();

        // Record the deposit
        $deposit = new Deposit();
        $deposit->employer_id = Auth::id();
        $deposit->amount = $request->amount;
        $deposit->save();

        // Redirect with success message
        return redirect()->route('employer.wallet.show')->with('success', 'Deposit successful.');
    }
}
