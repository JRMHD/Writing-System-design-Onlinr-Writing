@extends('layouts.app')

@section('content')
    <h1>Create New Assignment</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('employer.assignment.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="word_count">Word Count:</label>
            <input type="number" name="word_count" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="budget">Budget:</label>
            <input type="text" name="budget" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="deadline">Deadline:</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Assignment</button>
    </form>
@endsection
