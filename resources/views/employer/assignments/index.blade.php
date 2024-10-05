@extends('layouts.employer')

@section('content')
    <div style="font-family: 'Poppins', sans-serif; background-color: #F7F9FA; padding: 1.5rem;">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h1 style="font-size: 1.8rem; font-weight: 600; color: #333; margin: 0;">
                    <i class="fas fa-tasks" style="margin-right: 0.5rem;"></i> Your Assignments
                </h1>
                <a href="{{ route('employer.assignments.create') }}" class="btn-create-assignment"
                    style="background-color: #00A86B; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; text-decoration: none; font-size: 0.9rem; transition: background-color 0.3s ease;">
                    <i class="fas fa-plus-circle" style="margin-right: 0.3rem;"></i> New Assignment
                </a>
            </div>

            @if (session('success'))
                <div
                    style="background-color: #dff0d8; color: #3c763d; padding: 0.75rem; border-radius: 0.25rem; margin-bottom: 1rem; font-size: 0.9rem;">
                    <i class="fas fa-check-circle" style="margin-right: 0.3rem;"></i> {{ session('success') }}
                </div>
            @endif

            @if ($assignments->isEmpty())
                <p style="text-align: center; font-size: 1rem; color: #666;">
                    <i class="fas fa-info-circle" style="margin-right: 0.3rem;"></i> No assignments found. Start by creating
                    a new assignment.
                </p>
            @else
                <div style="overflow-x: auto; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 0.25rem;">
                    <table style="width: 100%; border-collapse: collapse; background-color: #fff; font-size: 0.9rem;">
                        <thead>
                            <tr style="background-color: #f4f4f4;">
                                <th style="padding: 0.75rem; text-align: left; font-weight: 500; color: #333;">
                                    <i class="fas fa-file-alt" style="margin-right: 0.3rem;"></i> Title
                                </th>
                                <th style="padding: 0.75rem; text-align: left; font-weight: 500; color: #333;">
                                    <i class="fas fa-tag" style="margin-right: 0.3rem;"></i> Topic
                                </th>
                                <th style="padding: 0.75rem; text-align: left; font-weight: 500; color: #333;">
                                    <i class="fas fa-calendar-alt" style="margin-right: 0.3rem;"></i> Deadline
                                </th>
                                <th style="padding: 0.75rem; text-align: left; font-weight: 500; color: #333;">
                                    <i class="fas fa-money-bill-wave" style="margin-right: 0.3rem;"></i> Budget
                                </th>
                                <th style="padding: 0.75rem; text-align: center; font-weight: 500; color: #333;">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr style="border-bottom: 1px solid #e0e0e0;">
                                    <td style="padding: 0.75rem;">{{ $assignment->title }}</td>
                                    <td style="padding: 0.75rem;">{{ $assignment->topic }}</td>
                                    <td style="padding: 0.75rem;">{{ $assignment->deadline }}</td>
                                    <td style="padding: 0.75rem;">KES {{ number_format($assignment->budget, 2) }}</td>
                                    <td style="padding: 0.75rem; text-align: center;">
                                        <div class="dropdown" style="position: relative; display: inline-block;">
                                            <button onclick="toggleDropdown({{ $assignment->id }})" class="dropbtn"
                                                style="background-color: transparent; border: none; cursor: pointer;">
                                                <i class="fas fa-ellipsis-v" style="color: #333;"></i>
                                            </button>
                                            <div id="dropdown-{{ $assignment->id }}" class="dropdown-content"
                                                style="display: none; position: absolute; right: 0; background-color: #f9f9f9; min-width: 120px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; border-radius: 0.25rem;">
                                                <a href="{{ route('employer.assignments.edit', $assignment->id) }}"
                                                    style="color: #333; padding: 0.5rem 1rem; text-decoration: none; display: block;">
                                                    <i class="fas fa-edit" style="margin-right: 0.3rem;"></i> Edit
                                                </a>
                                                <form action="{{ route('employer.assignments.destroy', $assignment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        style="width: 100%; text-align: left; background-color: transparent; border: none; color: #d9534f; padding: 0.5rem 1rem; cursor: pointer;"
                                                        onclick="return confirm('Are you sure you want to delete this assignment?')">
                                                        <i class="fas fa-trash-alt" style="margin-right: 0.3rem;"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <style>
        .btn-create-assignment:hover {
            background-color: #009e5a;
        }

        .dropdown-content a:hover,
        .dropdown-content button:hover {
            background-color: #f1f1f1;
        }

        .table tbody tr:hover {
            background-color: #f9f9f9;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .btn-create-assignment {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
                margin-bottom: 0.5rem;
            }

            td {
                border: none;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
            }
        }
    </style>

    <script>
        function toggleDropdown(id) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.id !== "dropdown-" + id && openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
            var dropdown = document.getElementById("dropdown-" + id);
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn') && !event.target.matches('.fa-ellipsis-v')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection
