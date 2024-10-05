@extends('layouts.writer')
@section('title', 'My Bids')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }

        h1 {
            font-size: 25px;
            font-weight: 600;
        }

        h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .bid-card {
            background-color: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bid-amount {
            font-weight: 500;
            color: #14a800;
        }

        .status-label {
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .status-accepted {
            background-color: #e7f8ed;
            color: #14a800;
        }

        .status-rejected {
            background-color: #ffefef;
            color: #d93025;
        }

        .status-pending {
            background-color: #fff8e1;
            color: #ffa000;
        }

        .status-inprogress {
            background-color: #e8eaed;
            color: #5f6368;
        }
    </style>

    <div style="max-width: 800px; margin: auto; padding: 1.5rem;">
        <h1 style="color: #333; margin-bottom: 1.5rem;">My Proposols</h1>

        @foreach ($bids as $bid)
            <div class="bid-card">
                <h2 style="color: #333; margin-bottom: 0.75rem;">
                    <i class="fas fa-file-alt" style="margin-right: 0.5rem;"></i>
                    {{ $bid->assignment->title }}
                </h2>
                <p style="color: #555; margin-bottom: 0.5rem;">
                    <strong>Bid Amount:</strong>
                    <span class="bid-amount">KES {{ number_format($bid->amount, 2) }}</span>
                </p>
                <p style="color: #555; margin-bottom: 0.5rem;">
                    <i class="far fa-clock" style="margin-right: 0.5rem;"></i>
                    <strong>Submitted:</strong>
                    {{ $bid->created_at->format('M d, Y H:i') }}
                </p>
                <p style="margin-bottom: 0.75rem;">
                    <strong>Status:</strong>
                    <span class="status-label status-{{ $bid->status }}">
                        @if ($bid->status === 'accepted')
                            Accepted
                        @elseif ($bid->status === 'rejected')
                            Rejected
                        @elseif ($bid->status === 'pending')
                            Pending
                        @else
                            In-progress
                        @endif
                    </span>
                </p>
                @if ($bid->message)
                    <p style="color: #555; margin-top: 0.75rem;">
                        <i class="fas fa-comment" style="margin-right: 0.5rem;"></i>
                        <strong>Message:</strong> {{ $bid->message }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
@endsection
