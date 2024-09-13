@extends('layouts.writer')

@section('content')
    <div style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 40px 20px;">
        <h1 style="color: #14a800; font-size: 32px; margin-bottom: 30px;">Writer Balance</h1>
        @if (session('success'))
            <div
                style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif
        <div style="background-color: #f2f7f2; border-radius: 8px; padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 24px; margin-bottom: 20px;">Balance Overview</h2>
            <p style="font-size: 18px; margin-bottom: 15px;">Current Balance: <strong
                    style="color: #14a800; font-size: 24px;">${{ number_format($writer->balance, 2) }}</strong></p>
            <p style="color: #656565; margin-bottom: 20px;">This is the amount available for withdrawal. Payments are
                typically processed within 1-3 business days.</p>
        </div>

        <div
            style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 24px; margin-bottom: 20px;">Request a Withdrawal</h2>
            <form method="POST" action="{{ route('writer.withdraw') }}" style="max-width: 400px;">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label for="amount"
                        style="display: block; margin-bottom: 10px; color: #001e00; font-weight: bold;">Amount to
                        withdraw:</label>
                    <div style="display: flex;">
                        <span
                            style="background-color: #e4ebe4; padding: 10px; border: 1px solid #ccc; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                        <input type="number" step="0.01" name="amount" id="amount" required
                            style="flex-grow: 1; padding: 10px; border: 1px solid #ccc; border-radius: 0 4px 4px 0;">
                    </div>
                </div>
                <button type="submit"
                    style="background-color: #14a800; color: #fff; border: none; padding: 12px 24px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 16px;">Request
                    Withdrawal</button>
            </form>
        </div>

        <div
            style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 24px; margin-bottom: 20px;">Payment History</h2>
            <ul style="list-style-type: none; padding: 0;">
                @forelse($payments as $payment)
                    <li
                        style="border-bottom: 1px solid #e4ebe4; padding: 15px 0; display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #001e00;">{{ $payment->created_at->format('Y-m-d') }}</span>
                        <span style="color: #14a800; font-weight: bold;">+${{ number_format($payment->amount, 2) }}</span>
                    </li>
                @empty
                    <li style="color: #656565; font-style: italic; padding: 15px 0;">No payments received yet.</li>
                @endforelse
            </ul>
        </div>

        <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px;">
            <h2 style="color: #001e00; font-size: 24px; margin-bottom: 20px;">Withdrawal History</h2>
            <ul style="list-style-type: none; padding: 0;">
                @forelse($withdrawals as $withdrawal)
                    <li
                        style="border-bottom: 1px solid #e4ebe4; padding: 15px 0; display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #001e00;">{{ $withdrawal->created_at->format('Y-m-d') }}</span>
                        <span
                            style="color: #656565; font-weight: bold;">-${{ number_format($withdrawal->amount, 2) }}</span>
                    </li>
                @empty
                    <li style="color: #656565; font-style: italic; padding: 15px 0;">No withdrawals made yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
