@extends('layouts.writer')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <div style="font-family: 'Poppins', sans-serif; max-width: 800px; margin: 0 auto; padding: 40px 20px;">
        <!-- Page Title -->
        <h1 style="color: #14a800; font-size: 24px; margin-bottom: 30px; font-weight: 600;">Writer Balance</h1>

        <!-- Success and Error Messages -->
        @if (session('success'))
            <div
                style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; padding: 15px; margin-bottom: 20px; font-weight: 400; font-size: 20px;">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; padding: 15px; margin-bottom: 20px; font-weight: 400; font-size: 20px;">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Balance Overview -->
        <div style="background-color: #f2f7f2; border-radius: 8px; padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 25px; margin-bottom: 20px; font-weight: 600;">Balance Overview</h2>
            <p style="font-size: 20px; margin-bottom: 15px; font-weight: 400;">Current Balance: <strong
                    style="color: #14a800; font-size: 25px; font-weight: 600;">KES
                    {{ number_format($writer->balance, 2) }}</strong></p>
            <p style="color: #656565; margin-bottom: 20px; font-size: 15px; font-weight: 400;">This is the amount available
                for withdrawal. Payments are typically processed within 1-3 business days.</p>
        </div>

        <!-- Request a Withdrawal -->
        <div
            style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 25px; margin-bottom: 20px; font-weight: 600;">Request a Withdrawal</h2>
            <button id="withdrawButton"
                style="background-color: #14a800; color: #fff; border: none; padding: 12px 24px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 20px; transition: background-color 0.3s;">
                <i class="fas fa-dollar-sign" style="margin-right: 8px;"></i>Withdraw Funds
            </button>
        </div>

        <!-- Withdrawal Modal -->
        <div id="withdrawalModal"
            style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); display: none; align-items: center; justify-content: center; z-index: 1000;">
            <div
                style="background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 40px; width: 90%; max-width: 500px; position: relative;">
                <button id="closeWithdrawalModal"
                    style="position: absolute; top: 15px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
                <h2 style="color: #001e00; font-size: 26px; margin-bottom: 20px; font-weight: 600;">Withdraw Funds</h2>
                <form id="withdrawalForm">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label for="withdraw_amount"
                            style="display: block; margin-bottom: 8px; color: #001e00; font-weight: 600;">Amount to
                            withdraw:</label>
                        <div style="display: flex; align-items: center;">
                            <span
                                style="background-color: #e4ebe4; padding: 10px; border: 1px solid #ccc; border-right: none; border-radius: 4px 0 0 4px; font-size: 20px;">KES</span>
                            <input type="number" step="0.01" name="amount" id="withdraw_amount" required
                                style="flex-grow: 1; padding: 10px; border: 1px solid #ccc; border-radius: 0 4px 4px 0; font-size: 15px;">
                        </div>
                        <span id="withdrawAmountError" style="color: red; font-size: 14px;"></span>
                    </div>
                    <button type="submit"
                        style="background-color: #14a800; color: #fff; border: none; padding: 15px 30px; border-radius: 25px; cursor: pointer; font-weight: bold; font-size: 20px; width: 100%; transition: background-color 0.3s;">
                        <i class="fas fa-paper-plane" style="margin-right: 8px;"></i>Request Withdrawal
                    </button>
                </form>

                <!-- Processing Animation -->
                <div id="withdrawProcessing" style="display: none; text-align: center; margin-top: 20px;">
                    <div class="spinner" style="display: flex; justify-content: center; align-items: center;">
                        <div
                            style="border: 4px solid #f3f3f3; border-top: 4px solid #14a800; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;">
                        </div>
                    </div>
                    <p style="color: #656565; margin-top: 10px; font-weight: 400; font-size: 15px;">Processing...</p>
                </div>

                <!-- Result Message -->
                <div id="withdrawResultMessage" style="display: none; text-align: center; margin-top: 20px;">
                    <p id="withdrawSuccessMessage" style="color: #14a800; font-weight: bold; font-size: 16px;"></p>
                    <p id="withdrawErrorMessage" style="color: red; font-weight: bold; font-size: 16px;"></p>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div
            style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 25px; margin-bottom: 20px; font-weight: 600;">Payment History</h2>
            <ul style="list-style-type: none; padding: 0;">
                @forelse($payments as $payment)
                    <li
                        style="border-bottom: 1px solid #e4ebe4; padding: 15px 0; display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #001e00; font-weight: 400;">{{ $payment->created_at->format('Y-m-d') }}</span>
                        <span style="color: #14a800; font-weight: bold;">+KES
                            {{ number_format($payment->amount, 2) }}</span>
                    </li>
                @empty
                    <li style="color: #656565; font-style: italic; padding: 15px 0;">No payments received yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- Recent Withdrawals -->
        <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px;">
            <h2 style="color: #001e00; font-size: 25px; margin-bottom: 20px; font
            <h2 style="color: #001e00;
                font-size: 25px; margin-bottom: 20px; font-weight: 600;">Withdrawal History</h2>
            <ul style="list-style-type: none; padding: 0;">
                @forelse($withdrawals as $withdrawal)
                    <li
                        style="border-bottom: 1px solid #e4ebe4; padding: 15px 0; display: flex; justify-content: space-between; align-items: center;">
                        <span
                            style="color: #001e00; font-weight: 400;">{{ $withdrawal->created_at->format('Y-m-d') }}</span>
                        <span style="color: #656565; font-weight: bold;">-KES
                            {{ number_format($withdrawal->amount, 2) }}</span>
                    </li>
                @empty
                    <li style="color: #656565; font-style: italic; padding: 15px 0;">No withdrawals made yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- Loading Overlay -->
        <div id="withdrawal-loader" class="loader-container">
            <div class="loader">
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
            </div>
        </div>
    </div>

    <!-- Styles for Spinner Animation -->
    <style>
        /* Spinner Animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Loader Container */
        .loader-container {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Loader Dots */
        .loader {
            display: flex;
            gap: 10px;
        }

        .loader-dot {
            width: 12px;
            height: 12px;
            background-color: #14a800;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .loader-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .loader-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        .loader-dot:nth-child(3) {
            animation-delay: 0s;
        }

        .loader-dot:nth-child(4) {
            animation-delay: -0.16s;
        }

        .loader-dot:nth-child(5) {
            animation-delay: -0.32s;
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }
    </style>

    <!-- JavaScript for Modal, AJAX, and Loader -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const withdrawButton = document.getElementById('withdrawButton');
            const withdrawalModal = document.getElementById('withdrawalModal');
            const closeWithdrawalModal = document.getElementById('closeWithdrawalModal');
            const withdrawalForm = document.getElementById('withdrawalForm');
            const withdrawProcessing = document.getElementById('withdrawProcessing');
            const withdrawResultMessage = document.getElementById('withdrawResultMessage');
            const withdrawSuccessMessage = document.getElementById('withdrawSuccessMessage');
            const withdrawErrorMessage = document.getElementById('withdrawErrorMessage');
            const loader = document.getElementById('withdrawal-loader');

            // Function to show the loader
            function showLoader() {
                loader.style.display = 'flex';
            }

            // Function to hide the loader
            function hideLoader() {
                loader.style.display = 'none';
            }

            // Open Withdrawal Modal
            withdrawButton.addEventListener('click', () => {
                const currentBalance = parseFloat("{{ $writer->balance }}");
                if (currentBalance <= 0) {
                    alert('You do not have sufficient balance to make a withdrawal.');
                    return;
                }
                withdrawalModal.style.display = 'flex';
            });

            // Close Withdrawal Modal
            closeWithdrawalModal.addEventListener('click', () => {
                withdrawalModal.style.display = 'none';
                resetWithdrawalForm();
            });

            // Close Modal when clicking outside the modal content
            window.addEventListener('click', (event) => {
                if (event.target == withdrawalModal) {
                    withdrawalModal.style.display = 'none';
                    resetWithdrawalForm();
                }
            });

            // Handle Withdrawal Form Submission
            withdrawalForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous errors and messages
                document.getElementById('withdrawAmountError').innerText = '';
                withdrawSuccessMessage.innerText = '';
                withdrawErrorMessage.innerText = '';
                withdrawResultMessage.style.display = 'none';

                const amount = document.getElementById('withdraw_amount').value;
                const token = document.querySelector('input[name="_token"]').value;

                // Basic client-side validation
                let hasError = false;
                if (amount < 0.01) {
                    document.getElementById('withdrawAmountError').innerText =
                        'Amount must be at least KES 0.01.';
                    hasError = true;
                }
                if (parseFloat(amount) > parseFloat("{{ $writer->balance }}")) {
                    document.getElementById('withdrawAmountError').innerText =
                        'Amount exceeds your current balance.';
                    hasError = true;
                }
                if (hasError) return;

                // Show processing animation
                withdrawProcessing.style.display = 'block';
                showLoader();

                // Send AJAX request
                fetch("{{ route('writer.withdraw') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({
                            amount: amount,
                        })
                    })
                    .then(response => {
                        hideLoader();
                        withdrawProcessing.style.display = 'none';
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw data;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            withdrawSuccessMessage.innerText = data.message;
                            withdrawResultMessage.style.display = 'block';
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        } else {
                            withdrawErrorMessage.innerText = data.message;
                            withdrawResultMessage.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        hideLoader();
                        withdrawProcessing.style.display = 'none';
                        withdrawErrorMessage.innerText = error.message ||
                            'An unexpected error occurred. Please try again.';
                        withdrawResultMessage.style.display = 'block';
                    });
            });

            // Function to reset the withdrawal form
            function resetWithdrawalForm() {
                withdrawalForm.reset();
                withdrawProcessing.style.display = 'none';
                withdrawResultMessage.style.display = 'none';
                withdrawSuccessMessage.innerText = '';
                withdrawErrorMessage.innerText = '';
                document.getElementById('withdrawAmountError').innerText = '';
            }
        });
    </script>
@endsection
