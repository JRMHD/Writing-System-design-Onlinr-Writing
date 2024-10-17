@extends('layouts.writer')

@section('content')
    <div class="container">
        <h2>Start a New Chat</h2>
        <form action="{{ route('writer.chat.start') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="employer_id">Select an Employer:</label>
                <select name="employer_id" id="employer_id" class="form-control" required>
                    @foreach ($employers as $employer)
                        <option value="{{ $employer->id }}">{{ $employer->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Start Chat</button>
        </form>

        <h2 class="mt-4">Your Conversations</h2>
        <ul class="list-group">
            @foreach ($conversations as $conversation)
                <li class="list-group-item">
                    <a href="{{ route('writer.chat.show', $conversation->id) }}">
                        Chat with {{ $conversation->employer->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
