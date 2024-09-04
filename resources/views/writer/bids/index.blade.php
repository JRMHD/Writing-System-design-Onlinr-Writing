@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Bids</h1>
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
    </div>
@endsection
