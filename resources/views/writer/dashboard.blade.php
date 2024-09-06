@extends('layouts.writer')

@section('content')
    <div style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;">
        <!-- Header -->
        <div
            style="background-color: #ffffff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
            <h1 style="color: #14a800; font-size: 24px; margin: 0;">Find Work</h1>
            <p style="color: #5e6d55; margin-top: 5px;">Proposals: {{ $bids->count() }} Available</p>
        </div>

        <div style="display: flex; gap: 20px;">
            <!-- Main Content Area -->
            <div style="flex: 3;">
                <!-- Available Assignments Section -->
                <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
                    <div style="padding: 20px; border-bottom: 1px solid #e0e0e0;">
                        <h2 style="color: #001e00; font-size: 18px; margin: 0;">Jobs you might like</h2>
                    </div>

                    @if ($availableAssignments->isEmpty())
                        <p style="color: #5e6d55; padding: 20px; text-align: center;">There are no available assignments at
                            the moment.</p>
                    @else
                        @foreach ($availableAssignments as $assignment)
                            <div style="padding: 20px; border-bottom: 1px solid #e0e0e0;">
                                <h3 style="color: #14a800; font-size: 16px; margin: 0 0 10px 0;">{{ $assignment->title }}
                                </h3>
                                <p style="color: #5e6d55; font-size: 14px; margin: 0 0 10px 0;">Word Count:
                                    {{ $assignment->word_count }} | Deadline: {{ $assignment->deadline->format('M d, Y') }}
                                </p>
                                <a href="{{ route('writer.assignments.show', $assignment->id) }}"
                                    style="background-color: #14a800; color: white; text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 14px; display: inline-block;">
                                    View Job
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div style="flex: 1;">
                <!-- Your Proposals Section -->
                <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
                    <div style="padding: 20px; border-bottom: 1px solid #e0e0e0;">
                        <h2 style="color: #001e00; font-size: 18px; margin: 0;">Your Proposals</h2>
                    </div>

                    @if ($bids->isEmpty())
                        <p style="color: #5e6d55; padding: 20px; text-align: center;">You have not placed any proposals yet.
                        </p>
                    @else
                        @foreach ($bids as $bid)
                            <div style="padding: 20px; border-bottom: 1px solid #e0e0e0;">
                                <h3 style="color: #14a800; font-size: 16px; margin: 0 0 10px 0;">
                                    {{ $bid->assignment->title }}</h3>
                                <p style="color: #14a800; font-size: 14px; margin: 0 0 5px 0;">Bid:
                                    ${{ number_format($bid->amount, 2) }}</p>
                                <p
                                    style="font-weight: bold; font-size: 14px; margin: 0 0 5px 0; color: {{ $bid->status == 'accepted' ? '#14a800' : ($bid->status == 'pending' ? '#FF5722' : '#d14836') }};">
                                    Status: {{ ucfirst($bid->status) }}
                                </p>
                                <p style="color: #5e6d55; font-size: 14px; margin: 0;">Submitted:
                                    {{ $bid->created_at->format('M d, Y') }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
