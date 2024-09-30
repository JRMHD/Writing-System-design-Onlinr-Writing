@extends('layouts.employer')

@section('content')
    <div style="font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <!-- Page Title -->
        <h1 style="color: #14a800; font-size: 36px; margin-bottom: 30px;">Employer Wallet</h1>

        <!-- Success and Error Messages -->
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

        <!-- Wallet Overview -->
        <div style="background-color: #f2f7f2; border-radius: 8px; padding: 30px; margin-bottom: 40px;">
            <h2 style="color: #001e00; font-size: 28px; margin-bottom: 20px;">Wallet Overview</h2>
            <p style="font-size: 20px; margin-bottom: 15px;">Current Balance: <strong
                    style="color: #14a800; font-size: 26px;">KES {{ number_format($wallet->balance, 2) }}</strong></p>
            <p style="color: #656565; margin-bottom: 20px;">Your wallet balance represents funds available for hiring and
                paying freelancers on our platform.</p>

            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="flex-basis: 48%;">
                    <h3 style="color: #001e00; font-size: 20px; margin-bottom: 10px;">Quick Actions:</h3>
                    <ul style="list-style-type: none; padding: 0;">
                        <li style="margin-bottom: 10px;"><a href="#deposit" style="color: #14a800; text-decoration: none;">➤
                                Deposit Funds</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #14a800; text-decoration: none;">➤
                                View Transaction History</a></li>
                        <li><a href="#" style="color: #14a800; text-decoration: none;">➤ Set Up Auto-Recharge</a></li>
                    </ul>
                </div>
                <div style="flex-basis: 48%;">
                    <h3 style="color: #001e00; font-size: 20px; margin-bottom: 10px;">Wallet Benefits:</h3>
                    <ul style="color: #656565; padding-left: 20px;">
                        <li style="margin-bottom: 5px;">Easy fund management for your projects</li>
                        <li style="margin-bottom: 5px;">Secure and instant payments to freelancers</li>
                        <li>Detailed transaction history for accounting</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Deposit Button -->
        <div style="text-align: center; margin-bottom: 40px;">
            <button id="depositButton"
                style="background-color: #14a800; color: #fff; border: none; padding: 15px 30px; border-radius: 25px; cursor: pointer; font-weight: bold; font-size: 18px; transition: background-color 0.3s;">
                Deposit Funds
            </button>
        </div>

        <!-- Deposit Modal -->
        <div id="depositModal"
            style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); display: none; align-items: center; justify-content: center; z-index: 1000;">
            <div
                style="background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 40px; width: 90%; max-width: 500px; position: relative;">
                <button id="closeModal"
                    style="position: absolute; top: 15px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
                <h2 style="color: #001e00; font-size: 26px; margin-bottom: 20px;">Deposit Funds</h2>
                <form id="depositForm">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label for="amount"
                            style="display: block; margin-bottom: 8px; color: #001e00; font-weight: bold;">Amount to
                            deposit:</label>
                        <div style="display: flex; align-items: center;">
                            <span
                                style="background-color: #e4ebe4; padding: 10px; border: 1px solid #ccc; border-right: none; border-radius: 4px 0 0 4px; font-size: 18px;">KES
                            </span>
                            <input type="number" step="0.01" name="amount" id="amount" required
                                style="flex-grow: 1; padding: 10px; border: 1px solid #ccc; border-radius: 0 4px 4px 0; font-size: 16px;">
                        </div>
                        <span id="amountError" style="color: red; font-size: 14px;"></span>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label for="phone"
                            style="display: block; margin-bottom: 8px; color: #001e00; font-weight: bold;">Phone
                            Number:</label>
                        <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}" required
                            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">
                        <span id="phoneError" style="color: red; font-size: 14px;"></span>
                    </div>
                    <button type="submit"
                        style="background-color: #14a800; color: #fff; border: none; padding: 15px 30px; border-radius: 25px; cursor: pointer; font-weight: bold; font-size: 18px; width: 100%; transition: background-color 0.3s;">
                        Deposit Now
                    </button>
                </form>

                <!-- Processing Animation -->
                <div id="processing" style="display: none; text-align: center; margin-top: 20px;">
                    <div class="spinner" style="display: flex; justify-content: center; align-items: center;">
                        <div
                            style="border: 4px solid #f3f3f3; border-top: 4px solid #14a800; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;">
                        </div>
                    </div>
                    <p style="color: #656565; margin-top: 10px;">Processing...</p>
                </div>

                <!-- Result Message -->
                <div id="resultMessage" style="display: none; text-align: center; margin-top: 20px;">
                    <p id="successMessage" style="color: #14a800; font-weight: bold; font-size: 16px;"></p>
                    <p id="errorMessage" style="color: red; font-weight: bold; font-size: 16px;"></p>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 30px;">
            <h2 style="color: #001e00; font-size: 28px; margin-bottom: 20px;">Recent Transactions</h2>
            <p style="color: #656565; margin-bottom: 20px;">Here's an overview of your recent wallet activities. For a full
                detailed report, please visit the Transaction History page.</p>

            <ul style="list-style-type: none; padding: 0;">
                @forelse($wallet->deposits->where('status', 'success')->take(5) as $deposit)
                    <li
                        style="border-bottom: 1px solid #e4ebe4; padding: 15px 0; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="color: #001e00; font-weight: bold;">Deposit</span>
                            <br>
                            <span
                                style="color: #656565; font-size: 14px;">{{ $deposit->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <span style="color: #14a800; font-weight: bold; font-size: 18px;">KES
                            {{ number_format($deposit->amount, 2) }}</span>
                    </li>
                @empty
                    <li style="color: #656565; font-style: italic; padding: 15px 0;">No recent transactions to display.</li>
                @endforelse
            </ul>

            @if ($wallet->deposits->where('status', 'success')->count() > 5)
                <div style="text-align: center; margin-top: 20px;">
                    <a href="#" style="color: #14a800; text-decoration: none; font-weight: bold;">View All
                        Transactions</a>
                </div>
            @endif
        </div>

        <!-- Loading Overlay -->
        <div id="wallet-loader" class="loader-container">
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
            const depositButton = document.getElementById('depositButton');
            const depositModal = document.getElementById('depositModal');
            const closeModal = document.getElementById('closeModal');
            const depositForm = document.getElementById('depositForm');
            const processing = document.getElementById('processing');
            const resultMessage = document.getElementById('resultMessage');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            const loader = document.getElementById('wallet-loader');

            // Function to show the loader
            function showLoader() {
                loader.style.display = 'flex';
            }

            // Function to hide the loader
            function hideLoader() {
                loader.style.display = 'none';
            }

            // Open Modal
            depositButton.addEventListener('click', () => {
                depositModal.style.display = 'flex';
            });

            // Close Modal
            closeModal.addEventListener('click', () => {
                depositModal.style.display = 'none';
                resetForm();
            });

            // Close Modal when clicking outside the modal content
            window.addEventListener('click', (event) => {
                if (event.target == depositModal) {
                    depositModal.style.display = 'none';
                    resetForm();
                }
            });

            // Handle Form Submission
            depositForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous errors and messages
                document.getElementById('amountError').innerText = '';
                document.getElementById('phoneError').innerText = '';
                successMessage.innerText = '';
                errorMessage.innerText = '';
                resultMessage.style.display = 'none';

                const amount = document.getElementById('amount').value;
                const phone = document.getElementById('phone').value;
                const token = document.querySelector('input[name="_token"]').value;

                // Basic client-side validation
                let hasError = false;
                if (amount < 0.01) {
                    document.getElementById('amountError').innerText = 'Amount must be at least KES 1.';
                    hasError = true;
                }
                const phoneRegex = /^[0-9]{10,15}$/;
                if (!phoneRegex.test(phone)) {
                    document.getElementById('phoneError').innerText = 'Please enter a valid phone number.';
                    hasError = true;
                }
                if (hasError) return;

                // Show processing animation
                processing.style.display = 'block';

                // Show loader overlay
                showLoader();

                // Send AJAX request
                fetch("{{ route('employer.wallet.deposit') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({
                            amount: amount,
                            phone: phone
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide processing animation and loader
                        processing.style.display = 'none';
                        hideLoader();

                        if (data.success) {
                            successMessage.innerText = data.message;
                            resultMessage.style.display = 'block';
                            // Optionally, refresh the wallet balance and transactions after a delay
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        } else {
                            errorMessage.innerText = data.message;
                            resultMessage.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        // Hide processing animation and loader
                        processing.style.display = 'none';
                        hideLoader();

                        errorMessage.innerText = 'An error occurred. Please try again.';
                        resultMessage.style.display = 'block';
                    });
            });

            // Function to reset the form
            function resetForm() {
                depositForm.reset();
                processing.style.display = 'none';
                resultMessage.style.display = 'none';
                successMessage.innerText = '';
                errorMessage.innerText = '';
                document.getElementById('amountError').innerText = '';
                document.getElementById('phoneError').innerText = '';
            }
        });
    </script>
@endsection
