@extends('layouts.writer')

@section('title', 'Assignment Details')

@section('content')
    <div style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;">
        <!-- Main Content Area -->
        <div style="max-width: 900px; margin: 0 auto;">
            <!-- Header -->
            <div
                style="background-color: #ffffff; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.12);">
                <h1 style="color: #14a800; font-size: 28px; margin: 0 0 15px 0;">{{ $assignment->title }}</h1>
                <p style="color: #5e6d55; font-size: 16px;">Assignment Details</p>
            </div>

            <!-- Assignment Details -->
            <div
                style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.12); padding: 30px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                    <div style="flex: 1; padding-right: 20px;">
                        <p style="color: #5e6d55; font-size: 16px; margin: 0 0 10px 0;"><strong>Word Count:</strong>
                            {{ $assignment->word_count }}</p>
                        <p style="color: #5e6d55; font-size: 16px; margin: 0 0 10px 0;"><strong>Deadline:</strong>
                            {{ $assignment->deadline->format('M d, Y') }}</p>
                    </div>
                    <div style="flex: 1; text-align: right; padding-left: 20px;">
                        <p style="color: #14a800; font-size: 20px; font-weight: bold; margin: 0;">Budget:
                            ${{ number_format($assignment->budget, 2) }}</p>
                    </div>
                </div>

                <h3 style="color: #001e00; font-size: 20px; margin: 0 0 15px 0;">Description:</h3>
                <p style="color: #5e6d55; font-size: 16px; line-height: 1.8; margin: 0 0 30px 0;">
                    {{ $assignment->description }}</p>

                <a href="{{ route('writer.bids.create', $assignment->id) }}"
                    style="background-color: #14a800; color: white; text-decoration: none; padding: 12px 24px; border-radius: 24px; font-size: 16px; display: inline-block; transition: background-color 0.3s ease;">
                    Place a Bid
                </a>
            </div>
        </div>
    </div>
@endsection
