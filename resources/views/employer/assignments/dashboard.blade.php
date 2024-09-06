@extends('layouts.employer')

@section('content')
    <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 2rem;">

        <!-- Welcome Message -->
        <div
            style="background-color: #ffffff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; text-align: center;">
            <p style="font-size: 1rem; color: #6c757d;">We're glad to see you back!</p>
        </div>

        <!-- Button to Create New Assignment -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ route('employer.assignments.create') }}"
                style="background-color: #28a745; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 500; transition: background-color 0.3s ease;">
                Create New Assignment
            </a>
        </div>

        <!-- Assignments Section -->
        <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1.5rem;">
            <h2 style="color: #28a745; font-size: 1.5rem; margin-bottom: 1.5rem;">Your Assignments</h2>

            @if ($assignments->isEmpty())
                <p style="text-align: center; color: #6c757d;">You have no assignments. Create a new assignment to get
                    started.</p>
            @else
                <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                    <thead>
                        <tr style="background-color: #f1f3f5; text-align: left;">
                            <th style="padding: 1rem; border-bottom: 2px solid #28a745;">Title</th>
                            <th style="padding: 1rem; border-bottom: 2px solid #28a745;">Status</th>
                            <th style="padding: 1rem; border-bottom: 2px solid #28a745;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $assignment)
                            <tr style="border-bottom: 1px solid #e9ecef;">
                                <td style="padding: 1rem;">{{ $assignment->title }}</td>
                                <td style="padding: 1rem;">{{ ucfirst($assignment->status) }}</td>
                                <td style="padding: 1rem;">
                                    <!-- Edit Assignment -->
                                    <a href="{{ route('employer.assignments.edit', $assignment->id) }}"
                                        style="background-color: #007bff; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; margin-right: 0.5rem; transition: background-color 0.3s ease;">
                                        Edit
                                    </a>
                                    <!-- View Bids for the Assignment -->
                                    <a href="{{ route('employer.assignments.bids.index', $assignment->id) }}"
                                        style="background-color: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; transition: background-color 0.3s ease;">
                                        View Bids
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
