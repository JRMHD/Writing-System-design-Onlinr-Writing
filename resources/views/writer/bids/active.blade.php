@extends('layouts.writer')

@section('content')
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .dashboard-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 15px;
        }

        .section-title {
            color: #14a800;
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card {
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            margin-bottom: 15px;
            padding: 12px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #14a800;
        }

        .card-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-info {
            flex: 1;
        }

        .card-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .status-badge {
            background: #e0f7e0;
            color: #14a800;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 5px;
        }

        .btn-primary {
            background-color: #14a800;
            color: #fff;
        }

        .btn-secondary {
            background-color: #0077b5;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .empty-state {
            text-align: center;
            color: #666;
            padding: 20px 0;
        }

        .assignment-title {
            font-size: 14px;
            font-weight: 600;
            margin: 0 0 5px;
        }

        .assignment-amount {
            font-size: 12px;
            color: #666;
        }
    </style>

    <div class="dashboard-container">
        <h1 class="section-title">Active Orders</h1>

        @forelse ($activeBids as $bid)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Order #{{ $bid->assignment_id }}</span>
                    <span class="status-badge">{{ ucfirst($bid->status) }}</span>
                </div>
                <div class="card-content">
                    <div class="card-info">
                        <h2 class="assignment-title">
                            <a href="{{ route('writer.assignments.show', $bid->assignment_id) }}"
                                style="color: #14a800; text-decoration: none;">{{ $bid->assignment->title }}</a>
                        </h2>
                        <p class="assignment-amount">KES {{ $bid->amount }}</p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('writer.assignments.show', $bid->assignment_id) }}"
                            class="btn btn-primary">View</a>
                        <form action="{{ route('writer.bids.cancel', $bid->id) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card empty-state">
                <p>No active bids found.</p>
            </div>
        @endforelse

        <h1 class="section-title">Completed Orders</h1>

        @forelse ($completedBids as $bid)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Order #{{ $bid->assignment_id }}</span>
                    <span class="status-badge">Completed</span>
                </div>
                <div class="card-content">
                    <div class="card-info">
                        <h2 class="assignment-title">
                            <a href="{{ route('writer.assignments.show', $bid->assignment_id) }}"
                                style="color: #14a800; text-decoration: none;">{{ $bid->assignment->title }}</a>
                        </h2>
                        <p class="assignment-amount">KES {{ $bid->amount }}</p>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('writer.assignments.show', $bid->assignment_id) }}"
                            class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card empty-state">
                <p>No completed assignments found.</p>
            </div>
        @endforelse

        <div style="margin-top: 15px; text-align: center;">
            <a href="{{ route('writer.bids.other_views') }}" class="btn btn-secondary">View Other Bids</a>
        </div>
    </div>
@endsection
