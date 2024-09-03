@extends('layouts.app')

@section('content')
    <h1>Writer Dashboard</h1>

    <h2>Available Assignments</h2>
    <ul>
        @foreach ($assignments as $assignment)
            <li>
                <a href="{{ route('writer.assignment.show', $assignment->id) }}">{{ $assignment->title }}</a> -
                {{ $assignment->word_count }} words - ${{ $assignment->budget }}
            </li>
        @endforeach
    </ul>
@endsection
