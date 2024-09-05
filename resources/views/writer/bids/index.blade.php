@extends('layouts.writer')

@section('content')
    <div class="container" style="padding: 2rem; max-width: 900px; margin: auto;">
        <h1 style="color: var(--deep-orange); font-size: 2rem; margin-bottom: 1.5rem;">Your Bids</h1>

        @if ($bids->isEmpty())
            <p style="color: var(--medium-gray); font-size: 1rem;">You have not placed any bids yet.</p>
        @else
            <table class="table"
                style="width: 100%; border-collapse: collapse; background-color: var(--white); border-radius: 0.5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <thead>
                    <tr style="background-color: var(--light-gray); color: var(--dark-gray);">
                        <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--deep-orange);">Assignment
                            Title</th>
                        <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--deep-orange);">Bid Amount
                        </th>
                        <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--deep-orange);">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bids as $bid)
                        <tr>
                            <td style="padding: 1rem; border-bottom: 1px solid var(--light-gray);">
                                {{ $bid->assignment->title }}</td>
                            <td
                                style="padding: 1rem; border-bottom: 1px solid var(--light-gray); color: var(--royal-blue); font-weight: 600;">
                                ${{ $bid->amount }}</td>
                            <td
                                style="padding: 1rem; border-bottom: 1px solid var(--light-gray); color: {{ $bid->status === 'pending' ? 'red' : ($bid->status === 'selected' ? 'green' : 'var(--deep-orange)') }}; font-weight: 600;">
                                {{ ucfirst($bid->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
