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

        .subscriptions-container {
            display: flex;
            justify-content: space-around;
            gap: 30px;
            flex-wrap: wrap;
        }

        .subscription-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            transition: all 0.3s ease;
        }

        .subscription-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .subscription-title {
            font-size: 25px;
            font-weight: 600;
            color: #14a800;
            margin-bottom: 10px;
        }

        .subscription-info {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        .subscription-info p {
            margin-bottom: 10px;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .back-btn {
            background-color: #14a800;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 50px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 40px;
        }

        .back-btn:hover {
            background-color: #108700;
        }
    </style>

    <div class="container">
        <h1><i class="fas fa-crown"></i> Your Active Subscriptions</h1>
        @if (session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if ($subscriptions->isEmpty())
            <p style="font-size: 18px; color: #333; text-align: center;"><i class="fas fa-info-circle"></i> You have no active
                subscriptions.</p>
        @else
            <div class="subscriptions-container">
                @foreach ($subscriptions as $subscription)
                    <div class="subscription-card">
                        <h2 class="subscription-title"><i class="fas fa-box"></i> {{ $subscription->plan_name }}</h2>
                        <p class="subscription-info"><strong><i class="fas fa-tag"></i> Price:</strong> KES
                            {{ $subscription->price }}</p>
                        <p class="subscription-info"><strong><i class="fas fa-calendar-plus"></i> Start Date:</strong>
                            {{ $subscription->start_date }}</p>
                        <p class="subscription-info"><strong><i class="fas fa-calendar-minus"></i> End Date:</strong>
                            {{ $subscription->end_date }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ route('employer.subscriptions.plans') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Subscription Plans
            </a>
        </div>
    </div>
@endsection
