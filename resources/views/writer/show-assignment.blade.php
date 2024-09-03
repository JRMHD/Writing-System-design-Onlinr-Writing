@extends('layouts.app')

@section('content')
    <h1>{{ $assignment->title }}</h1>
    <p>{{ $assignment->description }}</p>
    <p><strong>Word Count:</strong> {{ $assignment->word_count }}</p>
    <p><strong>Budget:</strong> ${{ $assignment->budget }}</p>
    <p><strong>Deadline:</strong> {{ $assignment->deadline }}</p>

    <h2>Place Your Bid</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('writer.assignment.bid', $assignment->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Bid Amount:</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="proposal">Proposal:</label>
            <textarea name="proposal" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Bid</button>
    </form>
@endsection
