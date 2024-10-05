@extends('layouts.employer')

@section('title', 'Bids for Assignment')

@section('content')
    <div style="font-family: 'Arial', sans-serif; background-color: #f2f2f2; padding: 20px;">
        <div
            style="max-width: 1000px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 30px;">
            <!-- Title -->
            <h1 style="font-size: 24px; font-weight: 600; color: #14a800; margin-bottom: 20px;">
                <i class="fas fa-clipboard-list" style="margin-right: 10px;"></i>Bids for "{{ $assignment->title }}"
            </h1>

            <!-- Bids List -->
            @foreach ($bids as $bid)
                <div style="border-bottom: 1px solid #e0e0e0; padding: 20px 0; display: flex; align-items: flex-start;">
                    <!-- Writer Profile Photo -->
                    <div style="flex-shrink: 0; margin-right: 20px;">
                        <img src="{{ asset('storage/' . $bid->writer->profile_image) }}" alt="Profile Image"
                            style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover;">
                    </div>

                    <div style="flex-grow: 1;">
                        <h2 style="font-size: 18px; font-weight: 600; color: #14a800; margin-bottom: 5px;">
                            {{ $bid->writer->name }}
                        </h2>
                        <p style="font-size: 14px; color: #656565; margin-bottom: 10px;">
                            <i class="fas fa-money-bill-wave" style="margin-right: 5px;"></i><strong>Bid Amount:</strong>
                            KES {{ number_format($bid->amount, 2) }}
                        </p>
                        <p style="font-size: 14px; color: #656565; margin-bottom: 10px;">
                            <i class="fas fa-clock" style="margin-right: 5px;"></i><strong>Submitted:</strong>
                            {{ $bid->created_at->format('M d, Y H:i') }}
                        </p>
                        <p style="font-size: 14px; color: #656565; margin-bottom: 10px;">
                            <i class="fas fa-info-circle" style="margin-right: 5px;"></i><strong>Status:</strong>
                            @if ($bid->status === 'accepted')
                                <span style="color: #14a800; font-weight: 600;">Accepted</span>
                            @elseif ($bid->status === 'rejected')
                                <span style="color: #dc3545; font-weight: 600;">Rejected</span>
                            @elseif ($bid->status === 'in-progress')
                                <span style="color: #0077b5; font-weight: 600;">In Progress</span>
                            @elseif ($bid->status === 'pending')
                                <span style="color: #ffc107; font-weight: 600;">Pending</span>
                            @else
                                <span style="color: #6c757d; font-weight: 600;">Unknown</span>
                            @endif
                        </p>
                        @if ($bid->message)
                            <p style="font-size: 14px; color: #656565; margin-bottom: 15px;">
                                <i class="fas fa-comment" style="margin-right: 5px;"></i><strong>Message:</strong>
                                {{ $bid->message }}
                            </p>
                        @endif

                        <!-- Buttons -->
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ url('writer/profile/public', $bid->writer->id) }}"
                                style="background-color: #14a800; color: #ffffff; padding: 8px 15px; border: none; border-radius: 20px; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center;">
                                <i class="fas fa-user" style="margin-right: 5px;"></i>View Profile
                            </a>

                            @if ($bid->status === 'pending')
                                <form
                                    action="{{ route('employer.bids.updateStatus', ['id' => $bid->id, 'status' => 'accepted']) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        style="background-color: #14a800; color: #ffffff; padding: 8px 15px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center;">
                                        <i class="fas fa-check" style="margin-right: 5px;"></i>Accept
                                    </button>
                                </form>

                                <form
                                    action="{{ route('employer.bids.updateStatus', ['id' => $bid->id, 'status' => 'rejected']) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        style="background-color: #dc3545; color: #ffffff; padding: 8px 15px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center;">
                                        <i class="fas fa-times" style="margin-right: 5px;"></i>Reject
                                    </button>
                                </form>

                                <form
                                    action="{{ route('employer.bids.updateStatus', ['id' => $bid->id, 'status' => 'in-progress']) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        style="background-color: #0077b5; color: #ffffff; padding: 8px 15px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center;">
                                        <i class="fas fa-spinner" style="margin-right: 5px;"></i>In Progress
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');

        button:hover,
        a:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 20px;
            }

            h2 {
                font-size: 16px;
            }

            p {
                font-size: 12px;
            }

            a,
            button {
                font-size: 12px;
                padding: 6px 12px;
            }
        }
    </style>
@endsection
