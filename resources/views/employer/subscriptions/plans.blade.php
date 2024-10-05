@extends('layouts.employer')

@section('content')
    <style>
        /* Existing styles */
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

        /* Modal styles */
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
            border: 1px solid #888;
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

        .modal-input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .close-btn {
            background-color: #ccc;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn {
            background-color: #14a800;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #108700;
        }
    </style>

    <div class="container">
        <h1>Available Subscription Plans</h1>

        <div class="plans-container">
            @foreach ($plans as $plan)
                <div class="plan-card">
                    <h2 class="plan-name">{{ $plan['name'] }} Plan</h2>
                    <p class="plan-price">KES {{ $plan['price'] }} / {{ $plan['duration'] }}</p>
                    <h3 class="benefits-title">Benefits</h3>
                    <ul class="benefits-list">
                        <li><i class="fas fa-check-circle"></i> Manage Orders</li>
                        <li><i class="fas fa-users"></i> Manage Writers</li>
                        <li><i class="fas fa-headset"></i> 24/7 Support</li>
                        <li><i class="fas fa-envelope"></i> Email Notifications</li>
                    </ul>
                    <button class="subscribe-btn"
                        onclick="openModal('{{ $plan['name'] }}', {{ $plan['price'] }}, '{{ $plan['duration'] }}')">Subscribe</button>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('employer.subscriptions.active') }}" class="active-subscriptions-link">
                <i class="fas fa-list-ul"></i> Active Subscriptions
            </a>
        </div>
    </div>

    <!-- Modal -->
    <div id="phoneModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">Enter Mpesa Phone Number</div>
            <form id="subscriptionForm" action="{{ route('employer.subscriptions.subscribe') }}" method="POST">
                @csrf
                <input type="hidden" name="plan" id="planInput">
                <input type="hidden" name="price" id="priceInput">
                <input type="hidden" name="duration" id="durationInput">
                <input type="tel" name="phone" id="phoneInput" class="modal-input" placeholder="07XX XXX XXX"
                    required>
                <button type="submit" class="submit-btn">Subscribe</button>
            </form>
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function openModal(plan, price, duration) {
            document.getElementById('planInput').value = plan;
            document.getElementById('priceInput').value = price;
            document.getElementById('durationInput').value = duration;
            document.getElementById('phoneModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('phoneModal').style.display = 'none';
        }
    </script>
@endsection
