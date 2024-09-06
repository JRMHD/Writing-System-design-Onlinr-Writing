@extends('layouts.writer')

@section('title', 'Available Assignments')

@section('content')
    <div style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;">
        <!-- Header -->
        <div
            style="background-color: #ffffff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.12); text-align: center;">
            <h1 style="color: #14a800; font-size: 24px; margin: 0;">Available Assignments</h1>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            @foreach ($assignments as $assignment)
                <div
                    style="flex: 1 1 calc(33.333% - 20px); background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.12); padding: 20px;">
                    <h2 style="color: #001e00; font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                        {{ $assignment->title }}
                    </h2>
                    <p style="color: #5e6d55; font-size: 14px; margin: 0 0 10px;"><strong>Word Count:</strong>
                        {{ $assignment->word_count }}</p>
                    <p style="color: #5e6d55; font-size: 14px; margin: 0 0 10px;"><strong>Deadline:</strong>
                        {{ $assignment->deadline->format('M d, Y') }}</p>
                    <p style="color: #5e6d55; font-size: 14px; margin: 0 0 20px;"><strong>Budget:</strong> <span
                            style="color: #14a800;">${{ number_format($assignment->budget, 2) }}</span></p>
                    <a href="{{ route('writer.assignments.show', $assignment->id) }}"
                        style="background-color: #14a800; color: white; text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 14px; display: inline-block;">
                        View Details
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
