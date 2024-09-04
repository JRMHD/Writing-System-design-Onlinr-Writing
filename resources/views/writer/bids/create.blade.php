@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Place a Bid</h1>
        <form action="{{ route('writer.bids.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="assignment_id">Assignment</label>
                <select name="assignment_id" id="assignment_id" class="form-control" required>
                    @foreach ($assignments as $assignment)
                        <option value="{{ $assignment->id }}">{{ $assignment->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Bid Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit Bid</button>
        </form>
    </div>
@endsection
