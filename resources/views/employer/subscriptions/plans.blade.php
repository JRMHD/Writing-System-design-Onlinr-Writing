@extends('layouts.employer')

@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }

        h1 {
            font-size: 34px;
            font-weight: 600;
            color: #14a800;
            text-align: center;
            margin-bottom: 40px;
        }

        .plans-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .plan-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            transition: all 0.3s ease;
        }

        .plan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .plan-name {
            font-size: 25px;
            font-weight: 600;
            color: #14a800;
            margin-bottom: 10px;
        }

        .plan-price {
            font-size: 20px;
            font-weight: 500;
            color: #333;
            margin-bottom: 20px;
        }

        .benefits-title {
            font-size: 20px;
            font-weight: 600;
            color: #14a800;
            margin-bottom: 15px;
        }

        .benefits-list {
            list-style: none;
            padding: 0;
            margin-bottom: 25px;
        }

        .benefits-list li {
            font-size: 15px;
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .benefits-list li i {
            color: #14a800;
            margin-right: 10px;
        }

        .subscribe-btn,
        .active-subscriptions-link {
            background-color: #14a800;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .subscribe-btn:hover,
        .active-subscriptions-link:hover {
            background-color: #108700;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 12px;
            width: 400px;
            text-align: center;
        }

        .modal-header {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        #confirmationMessage {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .modal-btn {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .submit-btn {
            background-color: #14a800;
            color: white;
            border: none;
        }

        .submit-btn:hover {
            background-color: #108700;
        }

        .close-btn {
            background-color: #ccc;
            color: #333;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

    <div class="container">
        <h1>Available Subscription Plans</h1>
        {{-- <p>Your current wallet balance: KES {{ $wallet->balance }}</p> --}}

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="plans-container">
            @foreach ($plans as $plan)
                <div class="plan-card">
                    <h2 class="plan-name">{{ $plan['name'] }}</h2>
                    <p class="plan-price">KES {{ $plan['price'] }} / {{ $plan['duration'] }}</p>
                    <h3 class="benefits-title">Benefits</h3>
                    <ul class="benefits-list">
                        <li><i class="fas fa-check-circle"></i> Manage Orders</li>
                        <li><i class="fas fa-users"></i> Manage Writers</li>
                        <li><i class="fas fa-headset"></i> 24/7 Support</li>
                        <li><i class="fas fa-envelope"></i> Email Notifications</li>
                    </ul>
                    <button class="subscribe-btn"
                        onclick="confirmSubscription('{{ $plan['name'] }}', {{ $plan['price'] }}, '{{ $plan['duration'] }}')">Subscribe</button>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('employer.subscriptions.active') }}" class="active-subscriptions-link">
                <i class="fas fa-list-ul"></i> Active Subscriptions
            </a>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">Confirm Subscription</div>
            <p id="confirmationMessage"></p>
            <form id="subscriptionForm" action="{{ route('employer.subscriptions.subscribe') }}" method="POST">
                @csrf
                <input type="hidden" name="plan" id="planInput">
                <input type="hidden" name="price" id="priceInput">
                <input type="hidden" name="duration" id="durationInput">
                <button type="submit" class="modal-btn submit-btn">Confirm Subscription</button>
            </form>
            <button class="modal-btn close-btn" onclick="closeModal()">Cancel</button>
        </div>
    </div>

    <script>
        function confirmSubscription(plan, price, duration) {
            document.getElementById('planInput').value = plan;
            document.getElementById('priceInput').value = price;
            document.getElementById('durationInput').value = duration;

            let message =
                `You are about to subscribe to the ${plan} Plan for KES ${price}. This amount will be deducted from your wallet balance. Do you want to proceed?`;
            document.getElementById('confirmationMessage').textContent = message;

            document.getElementById('confirmationModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
        }
    </script>
@endsection
