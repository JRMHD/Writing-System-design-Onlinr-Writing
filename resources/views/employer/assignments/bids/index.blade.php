@extends('layouts.employer')

@section('title', 'Bids for Assignment')

@section('content')
    <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7f9fa; padding: 2rem;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <!-- Title -->
            <h1 style="font-size: 2.5rem; font-weight: 600; color: #333; text-align: center; margin-bottom: 2rem;">
                Bids for "{{ $assignment->title }}"
            </h1>

            <!-- Bids List -->
            @foreach ($bids as $bid)
                <div
                    style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 2rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.75rem; font-weight: 600; color: #333; margin-bottom: 0.5rem;">
                        Bid by {{ $bid->writer->name }}
                    </h2>
                    <p style="font-size: 1rem; color: #555; margin-bottom: 0.5rem;">
                        <strong>Bid Amount:</strong> KES {{ number_format($bid->amount, 2) }}
                    </p>
                    <p style="font-size: 1rem; color: #555; margin-bottom: 0.5rem;">
                        <strong>Status:</strong>
                        @if ($bid->status === 'accepted')
                            <span style="color: #28a745; font-weight: 600;">Accepted</span> <!-- Green for accepted -->
                        @elseif ($bid->status === 'rejected')
                            <span style="color: #dc3545; font-weight: 600;">Rejected</span> <!-- Red for rejected -->
                        @elseif ($bid->status === 'in-progress')
                            <span style="color: #007bff; font-weight: 600;">In Progress</span> <!-- Blue for in-progress -->
                        @elseif ($bid->status === 'pending')
                            <span style="color: #ffc107; font-weight: 600;">Pending</span> <!-- Yellow for pending -->
                        @else
                            <span style="color: #6c757d; font-weight: 600;">Unknown</span> <!-- Gray for unknown -->
                        @endif
                    </p>
                    <p style="font-size: 1rem; color: #555; margin-bottom: 1rem;">
                        <strong>Submitted:</strong> {{ $bid->created_at->format('M d, Y H:i') }}
                    </p>
                    @if ($bid->message)
                        <p style="font-size: 1rem; color: #555; margin-bottom: 1rem;">
                            <strong>Message:</strong> {{ $bid->message }}
                        </p>
                    @endif
                    <!-- View Writer Profile Button -->
                    <a href="{{ url('writer/profile/public', $bid->writer->id) }}"
                        style="background-color: #007bff; color: #ffffff; padding: 0.5rem 1rem; border: none; border-radius: 5px; font-size: 1rem; text-decoration: none; cursor: pointer;">
                        View Writer Profile
                    </a>
                    <!-- Update Status Buttons -->
                    <div style="margin-top: 1rem;">
                        @if ($bid->status === 'pending')
                            <!-- Accept Bid -->
                            <form
                                action="{{ route('employer.bids.updateStatus', ['id' => $bid->id, 'status' => 'accepted']) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    style="background-color: #28a745; color: #ffffff; padding: 0.5rem 1rem; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; margin-right: 0.5rem;">
                                    Accept
                                </button>
                            </form>

                            <!-- Reject Bid -->
                            <form
                                action="{{ route('employer.bids.updateStatus', ['id' => $bid->id, 'status' => 'rejected']) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    style="background-color: #dc3545; color: #ffffff; padding: 0.5rem 1rem; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; margin-right: 0.5rem;">
                                    Reject
                                </button>
                            </form>

                            <!-- Mark as In Progress -->
                            <form
                                action="{{ route('employer.bids.updateStatus', ['id' => $bid->id, 'status' => 'in-progress']) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    style="background-color: #007bff; color: #ffffff; padding: 0.5rem 1rem; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer;">
                                    In Progress
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    /* Hover Effects */
    button:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }

    /* Add additional spacing for mobile devices */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        h1 {
            font-size: 2rem;
        }

        .card {
            padding: 1.5rem;
        }
    }
</style>
