@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Assignments</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('employer.assignments.create') }}" class="btn btn-primary mb-3">Create New Assignment</a>

        @if ($assignments->isEmpty())
            <p>No assignments found. Start by creating a new assignment.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Word Count</th>
                        <th>Deadline</th>
                        <th>Budget</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ $assignment->word_count }}</td>
                            <td>{{ $assignment->deadline }}</td>
                            <td>${{ number_format($assignment->budget, 2) }}</td>
                            <td>
                                <a href="{{ route('employer.assignments.edit', $assignment->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('employer.assignments.destroy', $assignment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this assignment?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
