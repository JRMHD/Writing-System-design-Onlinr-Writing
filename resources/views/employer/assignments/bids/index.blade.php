@extends('layouts.employer')

@section('title', 'Bids for Assignment')

@section('content')
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem;">

        <!-- Title Section -->
        <div class="title-section"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2.25rem; font-weight: 600; color: #2C3E50;">Bids for: <span
                    style="color: #FF5722;">{{ $assignment->title }}</span></h1>
        </div>

        <!-- No Bids Found -->
        @if ($bids->isEmpty())
            <div style="text-align: center; padding: 3rem 0;">
                <p style="font-size: 1.2rem; color: #7f8c8d;">No bids have been placed yet for this assignment. Check back
                    later.</p>
            </div>
        @else
            <!-- Bids Table -->
            <div class="bids-table"
                style="overflow-x: auto; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 8px; background-color: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-family: 'Inter', sans-serif;">
                    <thead style="background-color: #FF5722; color: #fff;">
                        <tr>
                            <th style="padding: 1rem; text-align: left;">Writer</th>
                            <th style="padding: 1rem; text-align: left;">Bid Amount</th>
                            <th style="padding: 1rem; text-align: left;">Message</th>
                            <th style="padding: 1rem; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bids as $bid)
                            <tr style="border-bottom: 1px solid #ecf0f1;">
                                <td style="padding: 1.25rem; color: #34495e;">{{ $bid->writer->name }}</td>
                                <td style="padding: 1.25rem; color: #2ecc71;">${{ number_format($bid->amount, 2) }}</td>
                                <td style="padding: 1.25rem; color: #7f8c8d;">{{ $bid->message ?? 'No message' }}</td>
                                <td style="padding: 1.25rem; text-align: center;">
                                    <form
                                        action="{{ route('employer.assignments.selectWriter', ['assignmentId' => $assignment->id]) }}"
                                        method="POST" style="display: inline-block;">
                                        @csrf
                                        <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                        <button type="submit" class="select-writer-btn"
                                            style="padding: 0.75rem 1.5rem; background-color: #3498db; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
                                            Select Writer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Styles for Hover and Responsive Behavior -->
    <style>
        /* Hover Effects for Buttons */
        .select-writer-btn:hover {
            background-color: #2980b9;
        }

        /* Table Row Hover Effect */
        tbody tr:hover {
            background-color: #fafafa;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 1.75rem;
            }

            table thead {
                display: none;
            }

            table tbody tr {
                display: block;
                margin-bottom: 1rem;
                background-color: #fff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                padding: 1rem;
            }

            table tbody tr td {
                display: block;
                text-align: right;
                padding: 0.75rem 0;
                position: relative;
                border-bottom: none;
            }

            table tbody tr td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                top: 0;
                font-weight: 600;
                color: #34495e;
                padding: 0.75rem;
            }

            table tbody tr td:last-child {
                text-align: center;
            }
        }
    </style>
@endsection
