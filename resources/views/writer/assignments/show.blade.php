@extends('layouts.writer')

@section('title', 'Assignment Details')

@section('content')
    <div style="font-family: 'Poppins', sans-serif; background-color: #f9f9f9; padding: 20px;">
        <!-- Main Content Area -->
        <div style="max-width: 800px; margin: 0 auto;">
            <!-- Header -->
            <div
                style="background-color: #ffffff; padding: 20px 30px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <h1 style="color: #14a800; font-size: 32px; font-family: 'Poppins SemiBold'; margin: 0;">
                    {{ $assignment->title }}
                </h1>
                <p style="color: #5e6d55; font-size: 18px; font-family: 'Poppins Medium'; margin: 5px 0;">Assignment Details
                </p>
            </div>

            <!-- Assignment Details -->
            <div
                style="background-color: #ffffff; border-radius: 8px; padding: 20px 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <!-- Left Section (Word Count, Deadline, etc.) -->
                    <div style="flex: 1;">
                        <p style="color: #5e6d55; font-size: 18px; font-family: 'Poppins Medium'; margin-bottom: 10px;">
                            <strong>Word Count:</strong> {{ $assignment->word_count }}
                        </p>
                        <p style="color: #5e6d55; font-size: 18px; font-family: 'Poppins Medium'; margin-bottom: 10px;">
                            <strong>Deadline:</strong> {{ $assignment->deadline->format('M d, Y') }}
                        </p>
                        <p style="color: #5e6d55; font-size: 18px; font-family: 'Poppins Medium'; margin-bottom: 10px;">
                            <strong>Language:</strong> {{ $assignment->language }}
                        </p>
                        <p style="color: #5e6d55; font-size: 18px; font-family: 'Poppins Medium'; margin-bottom: 10px;">
                            <strong>Academic Level:</strong> {{ $assignment->academic_level }}
                        </p>
                        <p style="color: #5e6d55; font-size: 18px; font-family: 'Poppins Medium'; margin-bottom: 10px;">
                            <strong>Topic:</strong> {{ $assignment->topic }}
                        </p>
                    </div>

                    <!-- Right Section (Budget) -->
                    <div style="flex: 1; text-align: right;">
                        <p style="color: #14a800; font-size: 22px; font-family: 'Poppins SemiBold'; margin: 0;">
                            Budget: KES {{ number_format($assignment->budget, 2) }}
                        </p>
                    </div>
                </div>

                <!-- File Upload Section -->
                @if ($assignment->file)
                    <div style="margin-bottom: 20px;">
                        <h3 style="color: #001e00; font-size: 18px; font-family: 'Poppins SemiBold'; margin-bottom: 10px;">
                            Attached File:
                        </h3>
                        <a href="{{ Storage::url($assignment->file) }}" target="_blank"
                            style="background-color: #14a800; color: white; text-decoration: none; padding: 10px 20px; border-radius: 20px; font-size: 16px; font-family: 'Poppins Medium'; display: inline-block;">
                            Download File
                        </a>
                    </div>
                @endif

                <!-- Description Section -->
                <h3 style="color: #001e00; font-size: 18px; font-family: 'Poppins SemiBold'; margin-bottom: 10px;">
                    Description:</h3>
                <p
                    style="color: #5e6d55; font-size: 16px; line-height: 1.5; font-family: 'Poppins Regular'; margin-bottom: 20px;">
                    {{ $assignment->description }}
                </p>

                <!-- Place a Bid Button -->
                <a href="{{ route('writer.bids.create', $assignment->id) }}"
                    style="background-color: #14a800; color: white; text-decoration: none; padding: 12px 30px; border-radius: 24px; font-size: 16px; font-family: 'Poppins Medium'; display: inline-block;">
                    Place a Bid
                </a>
            </div>
        </div>
    </div>
@endsection
