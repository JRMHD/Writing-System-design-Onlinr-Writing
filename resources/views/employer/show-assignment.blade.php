@extends('layouts.app')

@section('content')
    <h1>{{ $assignment->title }}</h1>
    <p>{{ $assignment->description }}</p>
    <p><strong>Word Count:</strong> {{ $assignment->word_count }}</p>
    <p><strong>Budget:</strong> ${{ $assignment->budget }}</p>
    <p><strong>Deadline:</strong> {{ $assignment->deadline }}</p>

    <h2>Bids</h2>
    <ul>
        @foreach ($bids as $bid)
            <li>
                {{ $bid->writer->name }} - ${{ $bid->amount }}
            </li>
        @endforeach
    </ul>
@endsection
