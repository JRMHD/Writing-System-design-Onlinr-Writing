<?php



namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Writer;
use App\Models\Payment;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class WriterPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:writer');
    }

    public function showBalance()
    {
        $writer = Auth::user();

        // Retrieve payments and withdrawals
        $payments = $writer->payments; // Use the relationship method
        $withdrawals = $writer->withdrawals; // Use the relationship method

        return view('writer.balance', compact('writer', 'payments', 'withdrawals'));
    }
}
