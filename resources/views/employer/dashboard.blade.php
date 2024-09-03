@extends('layouts.app')

@section('content')
    <h1>Employer Dashboard</h1>

    <a href="{{ route('employer.assignment.create') }}" class="btn btn-primary">Create New Assignment</a>

    <h2>Your Assignments</h2>
    <ul>
        @foreach ($assignments as $assignment)
            <li>
                <a href="{{ route('employer.assignment.show', $assignment->id) }}">{{ $assignment->title }}</a> -
                {{ $assignment->status }}
            </li>
        @endforeach
    </ul>
@endsection
