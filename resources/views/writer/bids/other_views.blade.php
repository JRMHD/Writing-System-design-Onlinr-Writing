@extends('layouts.writer')

@section('content')
    <div style="font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #14a800; font-size: 24px; margin-bottom: 20px;">Other Bids</h1>

        <table
            style="width: 100%; border-collapse: collapse; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 15px; text-align: left; border-bottom: 2px solid #e0e0e0;">Assignment</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 2px solid #e0e0e0;">Amount</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 2px solid #e0e0e0;">Status</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 2px solid #e0e0e0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bids as $bid)
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 15px;">
                            <a href="{{ route('writer.assignments.show', $bid->assignment_id) }}"
                                style="color: #14a800; text-decoration: none; font-weight: bold;">
                                {{ $bid->assignment->title }}
                            </a>
                        </td>
                        <td style="padding: 15px;">${{ $bid->amount }}</td>
                        <td style="padding: 15px;">
                            <span
                                style="background-color: #e0f7e0; color: #14a800; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                {{ ucfirst($bid->status) }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <a href="{{ route('writer.assignments.show', $bid->assignment_id) }}"
                                style="display: inline-block; background-color: #14a800; color: #ffffff; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 14px;">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: #666;">No bids found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <a href="{{ route('writer.bids.active') }}"
                style="display: inline-block; background-color: #0077b5; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-size: 14px;">
                Back to Active Bids
            </a>
        </div>
    </div>
@endsection
