@extends('layouts.employer')

@section('content')
    <div class="container">
        <h2>Start a New Chat</h2>
        <form action="{{ route('employer.chat.start') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="writer_id">Select a Writer:</label>
                <select name="writer_id" id="writer_id" class="form-control" required>
                    @foreach ($writers as $writer)
                        <option value="{{ $writer->id }}">{{ $writer->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Start Chat</button>
        </form>

        <h2 class="mt-4">Your Conversations</h2>
        <ul class="list-group">
            @foreach ($conversations as $conversation)
                <li class="list-group-item">
                    <a href="{{ route('employer.chat.show', $conversation->id) }}">
                        Chat with {{ $conversation->writer->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
