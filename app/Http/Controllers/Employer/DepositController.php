<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MpesaService;

class DepositController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->middleware('auth:employer');
        $this->mpesaService = $mpesaService;
    }

    /**
     * Handle deposit initiation
     */
    public function store(Request $request)
    {
        // Validate the deposit amount and phone number
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'phone' => 'required|digits_between:10,15',
        ]);

        $employer = Auth::user();
        $phone = $request->phone;
        $amount = $request->amount;

        // Retrieve or create the wallet for the authenticated employer
        $wallet = Wallet::firstOrCreate(['employer_id' => $employer->id]);

        // Create a pending deposit record
        $deposit = Deposit::create([
            'employer_id' => $employer->id,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Initiate STK Push
        $response = $this->mpesaService->stkPush(
            $phone,
            $amount,
            'EmployerDeposit',
            'Deposit Funds'
        );

        if ($response['success']) {
            // Store Mpesa Transaction ID
            $deposit->mpesa_transaction_id = $response['data']['CheckoutRequestID'] ?? null;
            $deposit->save();

            return response()->json(['success' => true, 'message' => 'STK Push initiated. Please complete the payment.']);
        } else {
            // Update deposit status to failed
            $deposit->status = 'failed';
            $deposit->save();

            return response()->json(['success' => false, 'message' => $response['message']]);
        }
    }
}
