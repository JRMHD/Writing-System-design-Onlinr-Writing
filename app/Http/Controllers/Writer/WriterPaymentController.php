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

        // Retrieve payments and withdrawals and sort them by created_at in descending order
        $payments = $writer->payments->sortByDesc('created_at');
        $withdrawals = $writer->withdrawals->sortByDesc('created_at');

        return view('writer.balance', compact('writer', 'payments', 'withdrawals'));
    }
}
