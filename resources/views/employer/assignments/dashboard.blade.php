@extends('layouts.employer')

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

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
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
        }

        .btn-primary {
            background-color: #14a800;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0e8600;
        }

        .btn-secondary {
            background-color: #ffd700;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #ffc800;
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Employer Dashboard</h1>
            <p class="wallet-balance">KES {{ number_format($walletBalance, 2) }}</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="background-color: #e6f7ff;">
                <p class="stat-title">Total Assignments</p>
                <p class="stat-value">{{ $totalAssignments }}</p>
            </div>
            <div class="stat-card" style="background-color: #fff2e6;">
                <p class="stat-title">Open Orders</p>
                <p class="stat-value">{{ $openAssignments }}</p>
            </div>
            <div class="stat-card" style="background-color: #e6ffe6;">
                <p class="stat-title">Ongoing Orders</p>
                <p class="stat-value">{{ $ongoingAssignments }}</p>
            </div>
            <div class="stat-card" style="background-color: #e6e6ff;">
                <p class="stat-title">Completed Orders</p>
                <p class="stat-value">{{ $completedAssignments }}</p>
            </div>
            <div class="stat-card" style="background-color: #ffe6e6;">
                <p class="stat-title">Total Bids</p>
                <p class="stat-value">{{ $totalBids }}</p>
            </div>
        </div>

        <div class="data-card">
            <h2 class="data-title">Active Subscription</h2>
            @if ($activeSubscription)
                <p style="font-size: 18px; color: #333;">Plan: {{ $activeSubscription->plan_name }}</p>
                <p style="font-size: 18px; color: #14a800;">Price: KES {{ number_format($activeSubscription->price, 2) }}
                </p>
            @else
                <p style="font-size: 18px; color: #666;">No active subscription found.</p>
            @endif
        </div>

        <div class="data-card">
            <h2 class="data-title">Recent Assignments</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentAssignments as $assignment)
                        <tr>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ $assignment->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="btn-group">
            <a href="{{ route('employer.assignments.create') }}" class="btn btn-primary">Create New Assignment</a>
            <a href="{{ route('employer.wallet.show') }}" class="btn btn-secondary">Manage Wallet</a>
        </div>
    </div>
@endsection
