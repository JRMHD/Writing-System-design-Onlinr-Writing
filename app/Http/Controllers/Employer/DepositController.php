<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MpesaService;
use Iankumu\Mpesa\Facades\Mpesa;
use Illuminate\Support\Facades\Log;

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
        Log::debug('Deposit initiation started');

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

        // Format the phone number
        $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;

        // Initiate STK Push
        $response = Mpesa::stkpush($phone, $amount, 'EmployerDeposit', $callbackurl = 'https://example.com/mpesa-callback');

        $result = json_decode((string)$response, true);
        Log::debug('Mpesa STK Push Response: ' . json_encode($result));

        if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
            // STK push was successful
            $deposit->mpesa_transaction_id = $result['CheckoutRequestID'] ?? null;
            $deposit->save();

            Log::info('STK Push initiated successfully for deposit ID: ' . $deposit->id);

            return response()->json([
                'success' => true,
                'message' => 'STK Push initiated. Please complete the payment on your phone.',
                'data' => [
                    'deposit_id' => $deposit->id,
                    'amount' => $amount,
                    'checkout_request_id' => $result['CheckoutRequestID'] ?? null
                ]
            ]);
        } else {
            // STK push failed
            $deposit->status = 'failed';
            $deposit->save();

            Log::error('STK Push failed for deposit ID: ' . $deposit->id . '. Mpesa response: ' . json_encode($result));

            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate STK push. Please try again or contact support.',
                'error' => $result['errorMessage'] ?? 'Unknown error occurred'
            ], 400);
        }
    }

    /**
     * Handle Mpesa callback
     */
    public function handleMpesaCallback(Request $request)
    {
        Log::info('Mpesa callback received: ' . json_encode($request->all()));

        // Process the callback and update the deposit status
        // This is a placeholder - you'll need to implement the actual logic
        // based on the structure of the callback data from Mpesa

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Callback received successfully']);
    }
}
