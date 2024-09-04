@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Employer Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>

        <!-- Button to create a new assignment -->
        <a href="{{ route('employer.assignments.create') }}" class="btn btn-primary mb-3">Create New Assignment</a>

        <!-- Display the list of assignments -->
        <h2>Your Assignments</h2>
        @if ($assignments->isEmpty())
            <p>You have no assignments. Create a new assignment to get started.</p>
        @else
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ ucfirst($assignment->status) }}</td>
                            <td>
                                <!-- Edit assignment -->
                                <a href="{{ route('employer.assignments.edit', $assignment->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <!-- View bids for the assignment -->
                                <a href="{{ route('employer.assignments.bids.index', $assignment->id) }}"
                                    class="btn btn-info btn-sm">View Bids</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
