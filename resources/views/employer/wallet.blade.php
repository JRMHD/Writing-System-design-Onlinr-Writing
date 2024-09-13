@extends('layouts.employer')

@section('content')
    <div style="font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
        <h1 style="color: #14a800; font-size: 32px; margin-bottom: 30px;">Employer Wallet</h1>
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
            <h2 style="color: #001e00; font-size: 24px; margin-bottom: 20px;">Wallet Overview</h2>
            <p style="font-size: 18px; margin-bottom: 15px;">Current Balance: <strong
                    style="color: #14a800; font-size: 24px;">${{ number_format($wallet->balance, 2) }}</strong></p>
            <p style="color: #656565; margin-bottom: 20px;">Your wallet balance represents funds available for hiring and
                paying freelancers on our platform.</p>

            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="flex-basis: 48%;">
                    <h3 style="color: #001e00; font-size: 18px; margin-bottom: 10px;">Quick Actions:</h3>
                    <ul style="list-style-type: none; padding: 0;">
                        <li style="margin-bottom: 10px;"><a href="#deposit" style="color: #14a800; text-decoration: none;">➤
                                Deposit Funds</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #14a800; text-decoration: none;">➤
                                View Transaction History</a></li>
                        <li><a href="#" style="color: #14a800; text-decoration: none;">➤ Set Up Auto-Recharge</a></li>
                    </ul>
                </div>
                <div style="flex-basis: 48%;">
                    <h3 style="color: #001e00; font-size: 18px; margin-bottom: 10px;">Wallet Benefits:</h3>
                    <ul style="color: #656565; padding-left: 20px;">
                        <li style="margin-bottom: 5px;">Easy fund management for your projects</li>
                        <li style="margin-bottom: 5px;">Secure and instant payments to freelancers</li>
                        <li>Detailed transaction history for accounting</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="deposit"
            style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 24px; margin-bottom: 20px;">Deposit Funds</h2>
            <p style="color: #656565; margin-bottom: 20px;">Add money to your wallet to ensure smooth transactions with
                freelancers. We accept various payment methods for your convenience.</p>

            <form method="POST" action="{{ route('wallet.deposit') }}" style="max-width: 400px;">
                @csrf
                <label for="amount" style="display: block; margin-bottom: 10px; color: #001e00; font-weight: bold;">Amount
                    to deposit:</label>
                <div style="display: flex; margin-bottom: 20px;">
                    <span
                        style="background-color: #e4ebe4; padding: 10px; border: 1px solid #ccc; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                    <input type="number" step="0.01" name="amount" required
                        style="flex-grow: 1; padding: 10px; border: 1px solid #ccc; border-radius: 0 4px 4px 0;">
                </div>
                <button type="submit"
                    style="background-color: #14a800; color: #fff; border: none; padding: 12px 24px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 16px;">Deposit
                    Now</button>
            </form>
        </div>

        <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px;">
            <h2 style="color: #001e00; font-size: 24px; margin-bottom: 20px;">Recent Transactions</h2>
            <p style="color: #656565; margin-bottom: 20px;">Here's an overview of your recent wallet activities. For a full
                detailed report, please visit the Transaction History page.</p>

            <ul style="list-style-type: none; padding: 0;">
                @forelse($wallet->deposits->take(5) as $deposit)
                    <li
                        style="border-bottom: 1px solid #e4ebe4; padding: 15px 0; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="color: #001e00; font-weight: bold;">Deposit</span>
                            <br>
                            <span
                                style="color: #656565; font-size: 14px;">{{ $deposit->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <span
                            style="color: #14a800; font-weight: bold; font-size: 18px;">+${{ number_format($deposit->amount, 2) }}</span>
                    </li>
                @empty
                    <li style="color: #656565; font-style: italic; padding: 15px 0;">No recent transactions to display.</li>
                @endforelse
            </ul>

            @if ($wallet->deposits->count() > 5)
                <div style="text-align: center; margin-top: 20px;">
                    <a href="#" style="color: #14a800; text-decoration: none; font-weight: bold;">View All
                        Transactions</a>
                </div>
            @endif
        </div>
    </div>
@endsection
