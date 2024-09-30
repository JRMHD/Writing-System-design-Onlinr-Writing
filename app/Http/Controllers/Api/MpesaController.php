<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    /**
     * Handle Mpesa Callback
     */
    public function callback(Request $request)
    {
        $data = $request->all();

        Log::info('Mpesa Callback Received:', $data);

        // Extract relevant data from the callback
        if (isset($data['Body']['stkCallback'])) {
            $body = $data['Body']['stkCallback'];
            $checkoutRequestID = $body['CheckoutRequestID'] ?? null;
            $resultCode = $body['ResultCode'] ?? null;
            $resultDesc = $body['ResultDesc'] ?? null;
            $merchantRequestID = $body['MerchantRequestID'] ?? null;

            // Find the deposit using CheckoutRequestID
            $deposit = Deposit::where('mpesa_transaction_id', $checkoutRequestID)->first();

            if ($deposit) {
                if ($resultCode == 0) {
                    // Payment was successful
                    $deposit->status = 'success';
                    $deposit->save();

                    // Update wallet balance
                    $wallet = Wallet::firstOrCreate(['employer_id' => $deposit->employer_id]);
                    $wallet->balance += $deposit->amount;
                    $wallet->save();
                } else {
                    // Payment failed
                    $deposit->status = 'failed';
                    $deposit->save();
                }
            } else {
                Log::warning('Deposit not found for CheckoutRequestID: ' . $checkoutRequestID);
            }
        } else {
            Log::warning('Invalid Mpesa Callback Data');
        }

        // Respond to Mpesa with a success message
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}
