@extends('layouts.employer')

@section('content')
    <div style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #14a800; font-size: 24px; margin-bottom: 20px;">Assignment Details</h1>
        <div
            style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px;">
            <p style="margin-bottom: 10px;"><strong style="color: #656565;">Title:</strong> <span
                    style="color: #14a800;">{{ $assignment->title }}</span></p>
            <p style="margin-bottom: 10px;"><strong style="color: #656565;">Description:</strong>
                {{ $assignment->description }}</p>
            <p style="margin-bottom: 10px;"><strong style="color: #656565;">Word Count:</strong> {{ $assignment->word_count }}
            </p>
            <p style="margin-bottom: 10px;"><strong style="color: #656565;">Deadline:</strong>
                {{ $assignment->deadline->format('Y-m-d') }}</p>
            <p style="margin-bottom: 10px;"><strong style="color: #656565;">Budget:</strong>
                ${{ number_format($assignment->budget, 2) }}</p>
            <p style="margin-bottom: 10px;">
                <strong style="color: #656565;">Writer Working on the Assignment:</strong>
                @if ($assignment->acceptedBid && $assignment->acceptedBid->writer)
                    <span style="color: #14a800; font-weight: bold;">{{ $assignment->acceptedBid->writer->name }}</span>
                @else
                    <span style="color: #808080; font-style: italic;">Checking...</span>
                @endif
            </p>
        </div>
        <div style="text-align: right;">
            <a href="http://localhost:8000/employer/given-out-assignments"
                style="display: inline-block; padding: 10px 20px; background-color: #14a800; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold; transition: background-color 0.3s;">
                Back to Assignments
            </a>
        </div>
    </div>
@endsection
