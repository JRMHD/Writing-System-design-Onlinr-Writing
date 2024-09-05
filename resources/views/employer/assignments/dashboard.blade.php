@extends('layouts.employer')

@section('content')
    <div class="container" style="padding: 2rem;">
        <!-- Welcome Message -->
        <div class="welcome-section" style="margin-bottom: 2rem;">
            {{-- <h1 style="color: var(--deep-orange); font-size: 2rem; margin-bottom: 0.5rem;">
                Welcome, {{ Auth::user()->name }}!
            </h1> --}}
            <p style="font-size: 1rem; color: var(--dark-gray);">We're glad to see you back!</p>
        </div>

        <!-- Button to Create New Assignment -->
        <div class="create-assignment-section" style="margin-bottom: 2rem;">
            <a href="{{ route('employer.assignments.create') }}" class="btn btn-primary"
                style="background-color: var(--deep-orange); border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; color: white; text-decoration: none; font-weight: 500; transition: background-color 0.3s ease;">
                Create New Assignment
            </a>
        </div>

        <!-- Assignments Section -->
        <div class="assignments-section">
            <h2 style="color: var(--deep-orange); margin-bottom: 1.5rem;">Your Assignments</h2>

            @if ($assignments->isEmpty())
                <p>You have no assignments. Create a new assignment to get started.</p>
            @else
                <table class="table mt-3"
                    style="width: 100%; border-collapse: collapse; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                    <thead>
                        <tr style="background-color: var(--light-gray); text-align: left;">
                            <th style="padding: 1rem; border-bottom: 2px solid var(--deep-orange);">Title</th>
                            <th style="padding: 1rem; border-bottom: 2px solid var(--deep-orange);">Status</th>
                            <th style="padding: 1rem; border-bottom: 2px solid var(--deep-orange);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $assignment)
                            <tr style="border-bottom: 1px solid var(--light-gray);">
                                <td style="padding: 1rem;">{{ $assignment->title }}</td>
                                <td style="padding: 1rem;">{{ ucfirst($assignment->status) }}</td>
                                <td style="padding: 1rem;">
                                    <!-- Edit Assignment -->
                                    <a href="{{ route('employer.assignments.edit', $assignment->id) }}"
                                        class="btn btn-warning btn-sm"
                                        style="background-color: var(--royal-blue); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: background-color 0.3s ease;">
                                        Edit
                                    </a>
                                    <!-- View Bids for the Assignment -->
                                    <a href="{{ route('employer.assignments.bids.index', $assignment->id) }}"
                                        class="btn btn-info btn-sm"
                                        style="background-color: var(--deep-orange); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: background-color 0.3s ease;">
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
