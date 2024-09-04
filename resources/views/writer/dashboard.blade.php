@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Writer Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>

        <h2>Your Bids</h2>
        @if ($bids->isEmpty())
            <p>You have not placed any bids yet.</p>
        @else
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Assignment Title</th>
                        <th>Bid Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bids as $bid)
                        <tr>
                            <td>{{ $bid->assignment->title }}</td>
                            <td>${{ $bid->amount }}</td>
                            <td>{{ ucfirst($bid->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('writer.bids.create') }}" class="btn btn-primary mt-3">Place a New Bid</a>
    </div>
@endsection
