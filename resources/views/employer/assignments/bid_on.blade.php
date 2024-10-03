@extends('layouts.employer')

@section('content')
    <div style="font-family: 'Poppins', sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #14a800; font-size: 24px; margin-bottom: 20px;">Assignments with Bids</h1>
        <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565;">Title
                        </th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565;">Word
                            Count</th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565;">
                            Deadline</th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565;">Budget
                        </th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565;">Bids
                            Count</th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">{{ $assignment->title }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">{{ $assignment->word_count }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                {{ $assignment->deadline->format('Y-m-d') }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                KES {{ number_format($assignment->budget, 2) }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">{{ $assignment->bids->count() }}
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                <a href="{{ route('employer.assignments.bids.index', $assignment->id) }}"
                                    style="display: inline-block; padding: 8px 16px; background-color: #14a800; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold; transition: background-color 0.3s;">View
                                    Bids</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
