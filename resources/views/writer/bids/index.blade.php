@extends('layouts.writer')

@section('title', 'My Bids')

@section('content')
    <div style="max-width: 1200px; margin: auto; padding: 2rem;">
        <h1 style="font-size: 2.5rem; font-weight: bold; color: #333; margin-bottom: 2rem;">My Bids</h1>

        @foreach ($bids as $bid)
            <div
                style="background-color: #fff; border: 1px solid #e1e1e1; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h2 style="font-size: 1.75rem; font-weight: 600; color: #333; margin-bottom: 1rem;">
                    {{ $bid->assignment->title }}</h2>
                <p style="color: #555; margin-bottom: 0.75rem;"><strong>Bid Amount:</strong>
                    ${{ number_format($bid->amount, 2) }}</p>
                <p style="color: #555; margin-bottom: 0.75rem;"><strong>Submitted:</strong>
                    {{ $bid->created_at->format('M d, Y H:i') }}</p>
                <p style="margin-bottom: 1rem; font-weight: 600;">
                    <strong>Status:</strong>
                    @if ($bid->status === 'accepted')
                        <span style="color: #28a745;">Accepted</span> <!-- Green for accepted -->
                    @elseif ($bid->status === 'rejected')
                        <span style="color: #dc3545;">Rejected</span> <!-- Red for rejected -->
                    @elseif ($bid->status === 'pending')
                        <span style="color: #ffc107;">Pending</span> <!-- Yellow for pending -->
                    @else
                        <span style="color: #6c757d;">In-progress</span> <!-- Gray for unknown -->
                    @endif
                </p>
                @if ($bid->message)
                    <p style="color: #555; margin-top: 1rem;"><strong>Message:</strong> {{ $bid->message }}</p>
                @endif
            </div>
        @endforeach
    </div>
@endsection
