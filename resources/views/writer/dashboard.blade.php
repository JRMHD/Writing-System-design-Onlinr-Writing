@extends('layouts.writer')

@section('content')
    <div class="container" style="padding: 2rem;">
        <!-- Button to Place a New Bid -->
        <div class="create-bid-section" style="margin-bottom: 2rem;">
            <a href="{{ route('writer.bids.create') }}" class="btn btn-primary"
                style="background-color: var(--deep-orange); border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; color: white; text-decoration: none; font-weight: 500; transition: background-color 0.3s ease;">
                Place a New Bid
            </a>
        </div>

        <!-- Bids Section -->
        <div class="bids-section">
            <h2 style="color: var(--deep-orange); margin-bottom: 1.5rem;">Your Bids</h2>

            @if ($bids->isEmpty())
                <p>You have not placed any bids yet.</p>
            @else
                <table class="table mt-3"
                    style="width: 100%; border-collapse: separate; border-spacing: 0; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                    <thead>
                        <tr style="background-color: var(--deep-orange); color: var(--white); text-align: left;">
                            <th style="padding: 1rem; border-bottom: 2px solid var(--deep-orange); font-weight: 600;">
                                Assignment Title</th>
                            <th style="padding: 1rem; border-bottom: 2px solid var(--deep-orange); font-weight: 600;">Bid
                                Amount</th>
                            <th style="padding: 1rem; border-bottom: 2px solid var(--deep-orange); font-weight: 600;">Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bids as $bid)
                            <tr style="border-bottom: 1px solid var(--light-gray);">
                                <td style="padding: 1rem; background-color: var(--white);">{{ $bid->assignment->title }}
                                </td>
                                <td style="padding: 1rem; background-color: var(--white); color: var(--royal-blue);">
                                    ${{ $bid->amount }}
                                </td>
                                <td style="padding: 1rem; background-color: var(--white);">
                                    <span
                                        style="
                                        color: 
                                        {{ $bid->status === 'pending' ? 'red' : ($bid->status === 'selected' ? 'green' : 'var(--deep-orange)') }}">
                                        {{ ucfirst($bid->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
