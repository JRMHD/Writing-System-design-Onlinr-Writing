@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Assignment</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employer.assignments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="word_count">Word Count</label>
                <input type="number" class="form-control" id="word_count" name="word_count" required>
            </div>
            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" required>
            </div>
            <div class="form-group">
                <label for="budget">Budget</label>
                <input type="number" class="form-control" id="budget" name="budget" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Assignment</button>
        </form>
    </div>
@endsection
