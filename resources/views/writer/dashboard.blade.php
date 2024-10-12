@extends('layouts.writer')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #14a800, #37a000);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-title {
            font-size: 36px;
            font-weight: 600;
            margin: 0;
        }

        .wallet-balance {
            font-size: 48px;
            font-weight: 600;
            color: #ffd700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-title {
            font-size: 16px;
            font-weight: 500;
            color: #666;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 600;
            color: #333;
        }

        .data-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .data-title {
            font-size: 20px;
            font-weight: 600;
            color: #14a800;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table th {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
        }

        .table td {
            font-size: 14px;
            padding: 12px 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .table tr:hover td {
            background-color: #e9ecef;
        }

        .btn {
            font-size: 14px;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 25px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            background-color: #14a800;
            color: white;
        }

        .btn:hover {
            background-color: #0e8600;
        }

        .jobs-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .job-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .job-title {
            font-size: 18px;
            font-weight: 600;
            color: #14a800;
            margin-bottom: 10px;
        }

        .job-details {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Writer Dashboard</h1>
            <p class="wallet-balance">KES {{ number_format($writer->balance, 2) }}</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="background-color: #e6f7ff;">
                <p class="stat-title">Total Proposals</p>
                <p class="stat-value">{{ $bids->count() }}</p>
            </div>
            <div class="stat-card" style="background-color: #fff2e6;">
                <p class="stat-title">Active Orders</p>
                <p class="stat-value">{{ $activeBidsCount }}</p>
            </div>
            <div class="stat-card" style="background-color: #e6ffe6;">
                <p class="stat-title">Completed Orders</p>
                <p class="stat-value">{{ $completedBidsCount }}</p>
            </div>
        </div>

        <div class="data-card">
            <h2 class="data-title">Withdrawal History</h2>
            @if ($withdrawals->isEmpty())
                <p style="color: #5e6d55; text-align: center;">No withdrawal history available.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($withdrawals->slice(0, 3) as $withdrawal)
                            <tr>
                                <td>KES {{ number_format($withdrawal->amount, 2) }}</td>
                                <td>{{ $withdrawal->created_at->format('M d, Y') }}</td>
                                <td>{{ ucfirst($withdrawal->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="data-card">
            <h2 class="data-title">Active Subscriptions</h2>
            @if ($subscriptions->isEmpty())
                <p style="color: #5e6d55; text-align: center;">You have no active subscriptions.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->plan_name }}</td>
                                <td>KES {{ number_format($subscription->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="data-card">
            <h2 class="data-title">Jobs you might like</h2>
            @if ($availableAssignments->isEmpty())
                <p style="color: #5e6d55; text-align: center;">There are no available assignments at the moment.</p>
            @else
                <div class="jobs-container">
                    @foreach ($availableAssignments as $assignment)
                        <div class="job-card">
                            <h3 class="job-title">{{ $assignment->title }}</h3>
                            <p class="job-details">Word Count: {{ $assignment->word_count }} | Deadline:
                                {{ $assignment->deadline->format('M d, Y') }}</p>
                            <a href="{{ route('writer.assignments.show', $assignment->id) }}" class="btn">View Job</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
