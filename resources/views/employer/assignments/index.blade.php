@extends('layouts.employer')

@section('content')
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
        <!-- Page Title -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2.5rem; color: #333; margin: 0;">Your Assignments</h1>
            <!-- Create New Assignment Button -->
            <a href="{{ route('employer.assignments.create') }}" class="btn-create-assignment"
                style="background-color: #FF5722; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; text-decoration: none; font-size: 1rem; transition: background-color 0.3s ease;">
                + New Assignment
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success"
                style="background-color: #dff0d8; color: #3c763d; padding: 1.25rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        <!-- No Assignments Found -->
        @if ($assignments->isEmpty())
            <p style="text-align: center; font-size: 1.25rem; color: #666;">No assignments found. Start by creating a new
                assignment.</p>
        @else
            <!-- Assignments Table -->
            <div class="table-responsive"
                style="overflow-x: auto; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <table class="table"
                    style="width: 100%; border-collapse: collapse; background-color: #fff; margin-bottom: 3rem; border-radius: 8px;">
                    <thead>
                        <tr style="background-color: #f4f4f4;">
                            <th style="padding: 1rem; text-align: left; font-weight: 500; color: #333;">Title</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 500; color: #333;">Word Count</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 500; color: #333;">Deadline</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 500; color: #333;">Budget</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 500; color: #333;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $assignment)
                            <tr style="border-bottom: 1px solid #e0e0e0;">
                                <td style="padding: 1.25rem;">{{ $assignment->title }}</td>
                                <td style="padding: 1.25rem;">{{ $assignment->word_count }}</td>
                                <td style="padding: 1.25rem;">{{ $assignment->deadline }}</td>
                                <td style="padding: 1.25rem;">${{ number_format($assignment->budget, 2) }}</td>
                                <td style="padding: 1.25rem; text-align: center;">
                                    <!-- Action Buttons -->
                                    <div style="display: flex; justify-content: center; gap: 0.5rem;">
                                        <!-- Edit Button -->
                                        <a href="{{ route('employer.assignments.edit', $assignment->id) }}"
                                            class="btn btn-edit"
                                            style="background-color: #f0ad4e; color: white; padding: 0.5rem 1.5rem; border-radius: 0.3rem; text-decoration: none; font-size: 0.9rem; transition: background-color 0.3s ease;">
                                            Edit
                                        </a>
                                        <!-- Delete Form -->
                                        <form action="{{ route('employer.assignments.destroy', $assignment->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete"
                                                style="background-color: #d9534f; color: white; padding: 0.5rem 1.5rem; border-radius: 0.3rem; border: none; font-size: 0.9rem; transition: background-color 0.3s ease;"
                                                onclick="return confirm('Are you sure you want to delete this assignment?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Custom Styles -->
    <style>
        /* Button Hover Effects */
        .btn-create-assignment:hover {
            background-color: #45a049;
        }

        .btn-edit:hover {
            background-color: #ec971f;
        }

        .btn-delete:hover {
            background-color: #c9302c;
        }

        /* Row Hover */
        .table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Media Query for Mobile Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            .btn-create-assignment {
                padding: 0.6rem 1.5rem;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
            }

            .table tbody tr td {
                display: block;
                text-align: right;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #e0e0e0;
            }

            .table tbody tr td::before {
                content: attr(data-label);
                float: left;
                font-weight: 500;
                color: #333;
            }
        }
    </style>
@endsection
