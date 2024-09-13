<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerWalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employer');
    }

    // Show employer wallet balance
    public function showWallet()
    {
        // Retrieve or create the wallet for the authenticated employer
        $wallet = Wallet::firstOrCreate(['employer_id' => Auth::id()]);

        // Pass the wallet to the view
        return view('employer.wallet', compact('wallet'));
    }

    // Handle deposit
    public function deposit(Request $request)
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

        // Redirect with success message
        return redirect()->route('employer.wallet.show')->with('success', 'Deposit successful.');
    }
}
